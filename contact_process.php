<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $to = "support@homeservice.com";
    $headers = "From: $email";
    $body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

    if(mail($to, $subject, $body, $headers)){
        echo "<script>alert('Message sent successfully!'); window.location='contact.php';</script>";
    }else{
        echo "<script>alert('Failed to send message.'); window.location='contact.php';</script>";
    }
}
?>
