<?php
$mysqli = new mysqli('127.0.0.1','root','','home_services');
if($mysqli->connect_error){ die('Database connection failed: '.$mysqli->connect_error); }
?>
