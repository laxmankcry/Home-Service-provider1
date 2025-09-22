<?php
require 'config.php';
$message = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $service = $_POST['service'];

    $stmt = $mysqli->prepare("INSERT INTO technicians (name,email,password,service) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$password,$service);
    if($stmt->execute()){
        $message = "Technician added successfully!";
    } else {
        $message = "Error: ".$stmt->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard — Home Service Provider</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: 'Poppins', sans-serif; margin:0; padding:0; background:#f5f5f5;}
    .wrap { max-width:1200px; margin:0 auto; padding:20px;}
    header { display:flex; justify-content:space-between; align-items:center; padding:20px 0; background:#2575fc; color:#fff; border-radius:8px; }
    header .logo { font-weight:700; font-size:24px; }
    nav a { color:#fff; margin-left:20px; text-decoration:none; font-weight:500; }
    nav a:hover { text-decoration:underline; }

    .dashboard-container { margin-top:40px; display:flex; justify-content:center; }
    .dashboard-card { background:#fff; padding:30px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.2); width:400px; }
    .dashboard-card h2 { text-align:center; margin-bottom:25px; color:#2575fc; }
    .dashboard-card form input, .dashboard-card form select { width:100%; padding:12px; margin-bottom:15px; border-radius:8px; border:1px solid #ccc; }
    .dashboard-card form button { width:100%; padding:12px; background:#2575fc; color:#fff; border:none; border-radius:8px; cursor:pointer; font-size:16px; transition:0.3s; }
    .dashboard-card form button:hover { background:#6a11cb; }
    .message { text-align:center; padding:12px; margin-bottom:15px; border-radius:8px; color:#155724; background:#d4edda; border:1px solid #c3e6cb; }
  </style>
</head>
<body>
<div class="wrap">
    <header>
        <div class="logo">HS Admin</div>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="services.php">Services</a>
            <a href="bookings.php">Bookings</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <h2>Add Technician</h2>

            <?php if($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="name" placeholder="Technician Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="service" required>
                    <option value="">Select Service</option>
                    <option value="Electrician">Electrician</option>
                    <option value="Plumber">Plumber</option>
                    <option value="Mobile Repair">Mobile Repair</option>
                    <option value="AC Repair">AC Repair</option>
                    <option value="Carpenter">Carpenter</option>
                    <option value="Cleaning Services">Cleaning Services</option>
                </select>
                <button type="submit">Add Technician</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
