<?php
// ---------------- DATABASE CONNECTION ----------------
$host = "localhost";
$user = "root";
$pass = "";
$db   = "home_services";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ---------------- INITIAL VARIABLES ----------------
$service = $_GET['service'] ?? 'Unknown Service';
$message = "";

// All working hours (1-hour slots)
$working_hours = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];

// Read selected date, default today
$selected_date = $_POST['date'] ?? date('Y-m-d');

// Prevent selecting past dates (server side)
if (strtotime($selected_date) < strtotime(date('Y-m-d'))) {
    $message = "Past dates are not allowed. Showing bookings for today.";
    $selected_date = date('Y-m-d');
}

// ---------------- GET ALREADY BOOKED SLOTS ----------------
$stmt = $conn->prepare("
  SELECT time 
  FROM bookings b 
  JOIN technicians t ON b.technician_id=t.id 
  WHERE t.service=? AND b.date=?
");
$stmt->bind_param("ss", $service, $selected_date);
$stmt->execute();
$result = $stmt->get_result();

$booked_slots = [];
while($row = $result->fetch_assoc()){
    $booked_slots[] = $row['time'];
}
$stmt->close();

$available_slots = array_diff($working_hours, $booked_slots);

// ---------------- HANDLE BOOKING FORM ----------------
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['time'])
    && in_array($_POST['time'], $available_slots) // only if still available
){
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];
    $problem = $_POST['problem']; // new field
    $time    = $_POST['time'];

    // Find available technician for this service/date/time
    $stmt_tech = $conn->prepare("
        SELECT * FROM technicians t 
        WHERE t.service=? 
        AND t.id NOT IN (
            SELECT technician_id FROM bookings WHERE date=? AND time=?
        )
        LIMIT 1
    ");
    $stmt_tech->bind_param("sss", $service, $selected_date, $time);
    $stmt_tech->execute();
    $tech_result = $stmt_tech->get_result();

    if($tech = $tech_result->fetch_assoc()){
        $tech_id = $tech['id'];

        // Insert booking (with address + problem)
        $stmt_booking = $conn->prepare("
            INSERT INTO bookings (technician_id, service, name, email, phone, address, problem, date, time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt_booking->bind_param(
            "issssssss",
            $tech_id, $service, $name, $email, $phone, $address, $problem, $selected_date, $time
        );

        if($stmt_booking->execute()){
            $message = "Booking confirmed! Technician: <b>".$tech['name']."</b> at <b>$time</b> on <b>$selected_date</b>.<br>
                        Your Address: <b>$address</b><br>
                        Issue: <b>$problem</b>";
        } else {
            $message = "Error: ".$stmt_booking->error;
        }
        $stmt_booking->close();
    } else {
        $message = "Sorry! No technician available at this time. Choose another slot.";
    }
    $stmt_tech->close();
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['time'])){
    // user tried to submit unavailable slot
    $message = "Sorry! This time slot is no longer available. Please pick another slot.";
}

$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Book Service — <?php echo $service; ?></title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
    --bg:#0f1724;
    --card:#101a2e;
    --accent:#3bc9db;
    --accent2:#4ade80;
    --muted:rgba(255,255,255,0.65);
    --glass: rgba(255,255,255,0.06);
    --radius:16px;
}
body{
    margin:0;
    background:radial-gradient(circle at 30% 20%,#0a162c,#040b16); 
    color:#e6f0f6;
    font-family:'Poppins',sans-serif;
    min-height:100vh;
}
.wrap{max-width:800px;margin:0 auto;padding:24px;}
header{
    display:flex;align-items:center;justify-content:space-between;
    padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06);
    flex-wrap:wrap;gap:16px;
}
.brand{
    display:flex;align-items:center;gap:12px;
}
.brand h1{
    font-size:22px;margin:0;color:#fff;white-space:nowrap;
}
.brand .small{font-size:13px;color:var(--muted);}
.logo{
    width:50px;height:50px;border-radius:50%;
    background:linear-gradient(135deg,var(--accent),var(--accent2));
    display:flex;align-items:center;justify-content:center;
    font-weight:700;color:#032;font-size:20px;
}
nav{
    display:flex;align-items:center;gap:16px;
}
nav a{
    color:var(--muted);text-decoration:none;font-weight:500;
}
nav a:hover{color:var(--accent2);}
.container{
    background:var(--glass);
    padding:36px;border-radius:var(--radius);
    backdrop-filter:blur(8px);
    margin-top:30px;
}
h1{text-align:center;margin-bottom:24px;color:#fff;}
form input, form select, form button{
    width:100%;padding:12px;margin:10px 0;border-radius:8px;
    border:none;font-size:15px;
}
form input, form select{background:var(--card);color:#fff;}
form button{
    background:linear-gradient(90deg,var(--accent),var(--accent2));
    color:#032;font-weight:700;cursor:pointer;transition:0.3s;
}
form button:hover{opacity:0.85;}
.message{
    padding:12px;margin-bottom:15px;text-align:center;
    background:#4ade80;color:#032;font-weight:600;border-radius:8px;
}
</style>
</head>
<body>
<div class="wrap">
    <!-- Header -->
    <header>
        <div class="brand">
            <div class="logo">HS</div>
            <div>
                <h1>Home Service Provider</h1>
                <div class="small">Fast. Trusted. At your home.</div>
            </div>
        </div>
        <nav>
            <a href="index.php">Home</a>
            <a href="service.php">Services</a>
            <a href="contact.php">Contact</a>
            <a href="login.php">Login Technician</a>
            <a href="signup.php">Signup Technician</a>
        </nav>
    </header>

    <!-- Booking Form -->
    <div class="container">
        <h1>Book Service: <?php echo $service; ?></h1>

        <?php if($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Select Date:</label>
            <input type="date" 
                   name="date" 
                   value="<?php echo $selected_date; ?>" 
                   min="<?php echo date('Y-m-d'); ?>" 
                   onchange="this.form.submit()">

            <?php if(!empty($available_slots)): ?>
                <label>Select Time Slot:</label>
                <select name="time" required>
                    <?php foreach($available_slots as $slot): ?>
                        <option value="<?php echo $slot; ?>"><?php echo $slot; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="text" name="name" placeholder="Your Full Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="tel" name="phone" placeholder="Your Phone Number" required>
                <input type="text" name="address" placeholder="Your Address" required>
                <input type="text" name="problem" placeholder="Describe the issue at your home" required>
                <button type="submit">Book Now</button>
            <?php else: ?>
                <p style="color:#f87171;text-align:center;">No available slots on this date. Please choose another date.</p>
            <?php endif; ?>
        </form>
    </div>
</div>
</body>
</html>
