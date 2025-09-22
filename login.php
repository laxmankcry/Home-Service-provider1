<?php
require 'config.php';
session_start();
$message = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT * FROM technicians WHERE email=?");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        if(password_verify($password,$row['password'])){
            $_SESSION['technician_id'] = $row['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $message = "Invalid credentials";
        }
    } else {
        $message = "Invalid credentials";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Technician Login — Home Service Provider</title>
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
.form-card{
  max-width:400px;
  margin:40px auto;
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
  background:rgba(255,0,0,0.2);
  color:#ffb3b3;
  border-radius:6px;
  margin-bottom:10px;
}
.signup-link{
  display:block;
  text-align:center;
  margin-top:12px;
}
.signup-link a{color:var(--accent2);text-decoration:none;font-weight:600;}
.signup-link a:hover{text-decoration:underline;}
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
          <h1>Home Service Provider</h1>
          <div class="small">Fast. Trusted. At your home.</div>
        </div>
      </div>
      <nav>
        <a href="index.php">Home</a>
        <a href="service.php">Services</a>
        <a href="contact.php">Contact</a>
      </nav>
    </header>

    <!-- Hero -->
    <section class="hero">
      <h2>Technician Login</h2>
      <p>Login to manage your slots & bookings</p>
    </section>

    <!-- Form -->
    <div class="form-card">
      <h3>Login</h3>
      <?php if($message): ?><div class="message"><?php echo $message;?></div><?php endif; ?>
      <form method="POST">
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit">Login</button>
      </form>
      <div class="signup-link">
        New here? <a href="signup.php">Sign up</a>
      </div>
    </div>

    <!-- Footer -->
    <footer>
      &copy; <span id="year"></span> Home Service Provider — Created by Kush Kumar and Laxman Kumar Chaudhary
    </footer>
  </div>

  <script>document.getElementById('year').textContent=new Date().getFullYear();</script>
</body>
</html>
