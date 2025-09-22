<?php
require 'config.php';
$message = "";

// form submit hone par
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $service = $_POST['service'];

    $stmt = $mysqli->prepare("INSERT INTO technicians (name,email,password,service) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$password,$service);
    if($stmt->execute()){
        $message = "Signup successful! <a href='login.php' style='color:#4ade80;text-decoration:underline;'>Login here</a>";
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
  <title>Home Service – Technician Signup</title>
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
      color:#e6f0f6;
      min-height:100vh;
      line-height:1.5;
    }
    .wrap{max-width:1180px;margin:0 auto;padding:24px;}
    header{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.06);}
    .brand{display:flex;align-items:center;gap:12px;}
    .logo{width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#3bc9db,#4ade80);display:flex;align-items:center;justify-content:center;font-weight:700;color:#032;font-size:22px;}
    nav a{color:var(--muted);text-decoration:none;margin-left:16px;font-weight:500;position:relative;}
    nav a:hover{color:#4ade80;}
    .card{
      max-width:480px;
      margin:40px auto;
      background:var(--glass);
      padding:36px;
      border-radius:var(--radius);
      backdrop-filter: blur(8px);
    }
    h2{text-align:center;margin-bottom:20px;color:var(--accent);}
    form input,form select{
      width:100%;
      padding:12px;
      margin-bottom:15px;
      border-radius:6px;
      border:1px solid #333;
      background:#fff;
      color:#000;
    }
    form button{
      width:100%;
      padding:12px;
      background:linear-gradient(90deg,var(--accent),var(--accent2));
      color:#032;
      border:none;
      border-radius:6px;
      cursor:pointer;
      font-weight:600;
    }
    form button:hover{opacity:0.9;}
    .message{
      text-align:center;
      padding:10px;
      background:#d4edda;
      color:#155724;
      border:1px solid #c3e6cb;
      border-radius:6px;
      margin-bottom:10px;
    }
    .login-link{
      text-align:center;
      margin-top:12px;
    }
    .login-link a{
      color:var(--accent2);
      text-decoration:none;
      font-weight:600;
    }
    .login-link a:hover{text-decoration:underline;}
    footer{text-align:center;padding:20px 0;margin-top:40px;color:var(--muted);}
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div class="brand">
        <div class="logo">HS</div>
        <div>
          <h1>Home Service Provider</h1>
          <div class="small">Fast. Trusted. At your home.</div>
        </div>
      </div>
      <nav>
        <a href="index.php">Signup</a>
        <a href="login.php">Login</a>
      </nav>
    </header>

    <div class="card">
      <h2>Technician Signup</h2>
      <?php if($message): ?>
        <div class="message"><?php echo $message; ?></div>
      <?php endif; ?>
      <form method="POST">
          <input type="text" name="name" placeholder="Full Name" required>
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
          <button type="submit">Signup</button>
      </form>
      <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
      </div>
    </div>

    <footer>
      &copy; <span id="year"></span> Home Service Provider — Created by Kush Kumar and Laxman Kumar Chaudhary
    </footer>
  </div>
  <script>
  document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
