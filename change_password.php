<?php
require 'config.php';
session_start();
if(!isset($_SESSION['technician_id'])){ header("Location: login.php"); exit; }

$tech_id = $_SESSION['technician_id'];
$message="";

if($_SERVER['REQUEST_METHOD']==='POST'){
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // check new == confirm
    if($new !== $confirm){
        $message="❌ New password and Confirm password do not match!";
    } else {
        // check current password
        $stmt=$mysqli->prepare("SELECT password FROM technicians WHERE id=? LIMIT 1");
        $stmt->bind_param("i",$tech_id);
        $stmt->execute();
        $res=$stmt->get_result();
        if($row=$res->fetch_assoc()){
            if(password_verify($current,$row['password'])){
                // update new password
                $hashed=password_hash($new,PASSWORD_DEFAULT);
                $up=$mysqli->prepare("UPDATE technicians SET password=? WHERE id=?");
                $up->bind_param("si",$hashed,$tech_id);
                if($up->execute()){
                    $message="✅ Password changed successfully!";
                } else {
                    $message="❌ Error: ".$up->error;
                }
                $up->close();
            } else {
                $message="❌ Current password is incorrect!";
            }
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Change Password</title>
<style>
body{font-family:Poppins,sans-serif;background:#0f1724;color:#fff;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}
.card{background:rgba(255,255,255,0.06);padding:30px;border-radius:12px;width:400px;}
h2{text-align:center;color:#4ade80;}
input{width:100%;padding:12px;margin:10px 0;border:none;border-radius:6px;background:#101a2e;color:#fff;}
button{width:100%;padding:12px;background:linear-gradient(90deg,#3bc9db,#4ade80);color:#032;border:none;border-radius:6px;cursor:pointer;font-weight:bold;}
button:hover{opacity:0.9;}
.message{text-align:center;margin-bottom:10px;}
.success{color:#b3ffcc;}
.error{color:#ff9999;}
a{color:#3bc9db;text-decoration:none;font-size:14px;}
a:hover{text-decoration:underline;}
</style>
</head>
<body>
<div class="card">
  <h2>Change Password</h2>
  <?php if($message): ?>
    <div class="message <?php echo (strpos($message,'✅')!==false)?'success':'error'; ?>">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>
  <form method="POST">
    <input type="password" name="current_password" placeholder="Current Password" required>
    <input type="password" name="new_password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
    <button type="submit">Update Password</button>
  </form>
  <p style="text-align:center;margin-top:12px;">
    <a href="dashboard.php">⬅ Back to Dashboard</a>
  </p>
</div>
</body>
</html>
