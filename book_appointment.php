<?php
session_start();
require 'config.php';

// Redirect if not logged in
if(!isset($_SESSION['technician_id'])){
    header('Location: technician_login.php');
    exit;
}

$tech_id = $_SESSION['technician_id'];

// Fetch technician info
$stmt = $mysqli->prepare("SELECT name, service FROM technicians WHERE id=?");
$stmt->bind_param("i", $tech_id);
$stmt->execute();
$result = $stmt->get_result();
$tech = $result->fetch_assoc();

$message = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $mysqli->prepare("INSERT INTO bookings (technician_id, service, name, email, phone, address, date, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $tech_id, $service, $name, $email, $phone, $address, $date, $time);

    if($stmt->execute()){
        $message = "Booking successful!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment</title>
<style>
body { font-family:Poppins, sans-serif; background:#0a162c; color:#e6f0f6; padding:20px; }
form { background: rgba(255,255,255,0.05); padding:20px; border-radius:12px; max-width:500px; margin:auto; }
input, select { width:100%; padding:10px; margin:8px 0; border-radius:6px; border:none; }
button { padding:12px 20px; border:none; border-radius:6px; background:#4ade80; color:#032; cursor:pointer; font-weight:700; }
.message { text-align:center; margin:10px 0; color:#4ade80; font-weight:700; }
</style>
</head>
<body>

<h2>Book Appointment for <?php echo htmlspecialchars($tech['name']); ?> (<?php echo htmlspecialchars($tech['service']); ?>)</h2>
<?php if($message) echo "<div class='message'>$message</div>"; ?>

<form method="post">
    <label>Customer Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Phone</label>
    <input type="text" name="phone" required>

    <label>Address</label>
    <input type="text" name="address" required>

    <label>Service</label>
    <input type="text" name="service" value="<?php echo htmlspecialchars($tech['service']); ?>" readonly>

    <label>Date</label>
    <input type="date" name="date" required>

    <label>Time</label>
    <input type="time" name="time" required>

    <button type="submit">Book Appointment</button>
</form>

</body>
</html>
