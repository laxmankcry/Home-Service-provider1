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
$stmt = $mysqli->prepare("SELECT name,email FROM technicians WHERE id=?");
$stmt->bind_param('i', $tech_id);
$stmt->execute();
$result = $stmt->get_result();
$tech = $result->fetch_assoc();

// Fetch services booked for this technician
$services_stmt = $mysqli->prepare("SELECT * FROM services WHERE technician_id=? ORDER BY date DESC");
$services_stmt->bind_param('i', $tech_id);
$services_stmt->execute();
$services_result = $services_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technician Dashboard — Home Service Provider</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: radial-gradient(circle at 30% 20%, #0a162c,#040b16);
      color: #e6f0f6;
      font-family: 'Poppins', sans-serif;
      margin:0;
      min-height:100vh;
      display:flex;
      flex-direction:column;
    }
    .wrap { max-width:1180px; margin:0 auto; padding:24px; flex:1; }
    header { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.06);}
    .brand { display:flex; align-items:center; gap:12px; }
    .logo { width:60px; height:60px; border-radius:50%; background:linear-gradient(135deg,#3bc9db,#4ade80); display:flex; align-items:center; justify-content:center; font-weight:700; color:#032; font-size:22px;}
    nav a { color: rgba(255,255,255,0.65); text-decoration:none; margin-left:16px; font-weight:500; }
    nav a:hover { color:#4ade80; }
    .hero-card, .dashboard-card { background: rgba(255,255,255,0.06); padding:28px; border-radius:16px; backdrop-filter: blur(8px); margin-bottom:24px; }
    .dashboard-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; }
    .dashboard-card h3 { color:#4ade80; margin-bottom:12px; }
    table { width:100%; border-collapse: collapse; }
    table th, table td { padding:12px; text-align:left; border-bottom:1px solid rgba(255,255,255,0.1); }
    table th { color:#4ade80; }
    table td { color:#e6f0f6; }
    .status { padding:4px 8px; border-radius:8px; font-size:14px; font-weight:600; }
    .status.pending { background:#f59e0b; color:#000; }
    .status.completed { background:#4ade80; color:#032; }
    .logout-btn { background:linear-gradient(90deg,#3bc9db,#4ade80); color:#032; padding:10px 16px; border:none; border-radius:8px; cursor:pointer; font-weight:700; text-decoration:none;}
    footer { text-align:center; padding:20px 0; margin-top:auto; color: rgba(255,255,255,0.65); border-top:1px solid rgba(255,255,255,0.06); }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div class="brand">
        <div class="logo">HS</div>
        <div>
          <h1>Technician Dashboard</h1>
          <div class="small">Welcome, <?php echo htmlspecialchars($tech['name']); ?>!</div>
        </div>
      </div>
      <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="technician_dashboard.php">Reserve Appointment</a>
        <a href="change_password.php">Change Password</a>
        <a href="logout.php" class="logout-btn">Logout</a>
      </nav>
    </header>

    <section class="dashboard-grid">
      <div class="dashboard-card">
        <h3>Technician Info</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($tech['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($tech['email']); ?></p>
      </div>

      <div class="dashboard-card">
        <h3>Assigned Services</h3>
        <?php if($services_result->num_rows > 0): ?>
          <table>
            <thead>
              <tr>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $services_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['service']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No booked services yet.</p>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <footer>
    &copy; <?php echo date('Y'); ?> Home Service Provider — Crafted for your college project
  </footer>
</body>
</html>
