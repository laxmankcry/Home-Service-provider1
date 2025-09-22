<?php
require 'config.php';
session_start();
if(!isset($_SESSION['technician_id'])){ header('Location: login.php'); exit; }

$tech_id = $_SESSION['technician_id'];
$message="";

// technician name for welcome
$tech_name="";
$t=$mysqli->prepare("SELECT name FROM technicians WHERE id=? LIMIT 1");
$t->bind_param("i",$tech_id);
$t->execute();
$res=$t->get_result();
if($row=$res->fetch_assoc()){ $tech_name=$row['name']; }
$t->close();

// add slot
if($_SERVER['REQUEST_METHOD']==='POST'){
    $date=$_POST['date'];
    $time=$_POST['time'];

    // past date block
    if(strtotime($date) < strtotime(date('Y-m-d'))){
        $message="❌ You cannot add a past date slot!";
    } else {
        $check=$mysqli->prepare("SELECT * FROM technician_slots WHERE technician_id=? AND date=? AND time=?");
        $check->bind_param("iss",$tech_id,$date,$time);
        $check->execute();
        $res=$check->get_result();
        if($res->num_rows>0){
            $message="⚠️ This slot already exists!";
        } else {
            $stmt=$mysqli->prepare("INSERT INTO technician_slots (technician_id,date,time) VALUES (?,?,?)");
            $stmt->bind_param("iss",$tech_id,$date,$time);
            if($stmt->execute()){
                $message="✅ Slot added successfully!";
            } else {
                $message="❌ Error: ".$stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}

// fetch all slots
$slots=$mysqli->prepare("SELECT * FROM technician_slots WHERE technician_id=? ORDER BY date,time");
$slots->bind_param("i",$tech_id);
$slots->execute();
$result=$slots->get_result();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Technician Dashboard — Home Service Provider</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
  font-family: 'Poppins', sans-serif;
}
body{
  margin:0; 
  background:radial-gradient(circle at 30% 20%,#0a162c,#040b16); 
  color:#e6f0f6; min-height:100vh; line-height:1.5;
}
.wrap{max-width:1180px;margin:0 auto;padding:24px;}
header{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.06);}
.brand{display:flex;align-items:center;gap:12px;}
.logo{width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#3bc9db,#4ade80);display:flex;align-items:center;justify-content:center;font-weight:700;color:#032;font-size:22px;}
nav a{color:var(--muted);text-decoration:none;margin-left:16px;font-weight:500;position:relative;}
nav a:hover{color:#4ade80;}
.hero{
  background:var(--glass);
  padding:36px;
  border-radius:var(--radius);
  backdrop-filter: blur(8px);
  text-align:center;
  margin-top:36px;
}
.hero h2{margin:0;color:var(--accent2);}
.form-card{
  max-width:500px;
  margin:30px auto;
  background:var(--glass);
  padding:28px;
  border-radius:var(--radius);
  backdrop-filter: blur(8px);
}
.form-card h3{text-align:center;margin-bottom:20px;color:var(--accent);}
.form-card input{
  width:100%;
  padding:12px;
  margin-bottom:15px;
  border-radius:6px;
  border:1px solid rgba(255,255,255,0.1);
  background:var(--card);
  color:#fff;
}
.form-card button{
  width:100%;
  padding:12px;
  background:linear-gradient(90deg,var(--accent),var(--accent2));
  color:#032;
  border:none;
  border-radius:6px;
  cursor:pointer;
  font-weight:700;
}
.form-card button:hover{opacity:0.9;}
.message{
  text-align:center;
  padding:10px;
  border-radius:6px;
  margin-bottom:10px;
}
.success{background:rgba(46,204,113,0.2);color:#b3ffcc;}
.error{background:rgba(255,0,0,0.2);color:#ff9999;}
.table-card{
  max-width:700px;
  margin:30px auto;
  background:var(--glass);
  padding:28px;
  border-radius:var(--radius);
  backdrop-filter: blur(8px);
}
table{
  width:100%;
  border-collapse:collapse;
  color:#e6f0f6;
}
table th,table td{
  padding:8px;
  border-bottom:1px solid rgba(255,255,255,0.06);
  text-align:left;
}
footer{text-align:center;padding:20px 0;margin-top:40px;color:var(--muted);}
</style>
</head>
<body>
  <div class="wrap">
    <!-- Header -->
    <header>
      <div class="brand">
        <div class="logo">HS</div>
        <div>
          <h1>Home Service Provider <span style="font-weight:400; color:var(--accent2);">Dashboard</span></h1>
          <div class="small">Fast. Trusted. At your home.</div>
        </div>
      </div>
      <nav>
        <a href="dashboard.php">Home</a>
        <a href="technician_dashboard.php">Reserve Appointment</a>

        <a href="change_password.php">Change Password</a>
        <a href="logout.php">Logout</a>
      </nav>
    </header>

    <!-- Hero -->
    <section class="hero">
      <h2>Welcome, <?php echo htmlspecialchars($tech_name); ?> 👋</h2>
      <p>Technician Dashboard — Manage your available slots</p>
    </section>

    <!-- Form -->
    <div class="form-card">
      <h3>Add Available Slot</h3>
      <?php if($message): ?>
        <div class="message <?php echo (strpos($message,'✅')!==false)?'success':'error'; ?>">
          <?php echo $message;?>
        </div>
      <?php endif; ?>
      <form method="POST">
        <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
        <input type="time" name="time" required>
        <button type="submit">Add Slot</button>
      </form>
    </div>

    <!-- Slots Table -->
    <div class="table-card">
      <h3>Your Existing Slots</h3>
      <table>
        <tr><th>Date</th><th>Time</th></tr>
        <?php while($row=$result->fetch_assoc()): ?>
          <tr><td><?php echo $row['date'];?></td><td><?php echo $row['time'];?></td></tr>
        <?php endwhile; ?>
      </table>
    </div>

    <!-- Footer -->
    <footer>
      &copy; <span id="year"></span> Home Service Provider — Created by Kush Kumar and Laxman Kumar Chaudhary
    </footer>
  </div>

<script>
document.getElementById('year').textContent=new Date().getFullYear();

// popup when page loads
window.addEventListener('load',()=>{
  alert('Welcome <?php echo addslashes($tech_name); ?>! You are now in your Technician Dashboard.');
});
</script>
</body>
</html>
