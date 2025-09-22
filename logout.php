<?php
session_start();
session_unset();
session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Logged Out — Home Service Provider</title>
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
  .hero{
    background:var(--glass);
    padding:36px;
    border-radius:var(--radius);
    backdrop-filter: blur(8px);
    text-align:center;
    margin-top:36px;
  }
  .btn-primary{
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:linear-gradient(90deg,var(--accent),var(--accent2));
    color:#032;
    border-radius:6px;
    text-decoration:none;
    font-weight:700;
  }
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
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
      </nav>
    </header>

    <section class="hero">
      <h2>You have been logged out</h2>
      <p>Thank you for using Home Service Provider.</p>
      <a href="login.php" class="btn-primary">Login Again</a>
    </section>

    <footer>
      &copy; <span id="year"></span> Home Service Provider — Crafted for your college project
    </footer>
  </div>
  <script>
  document.getElementById('year').tex
