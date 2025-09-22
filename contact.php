<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us — Home Service Provider</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin:0;
      background: radial-gradient(circle at 30% 20%, #0a162c,#040b16);
      color: #e6f0f6;
      min-height:100vh;
    }
    .wrap { max-width:1180px; margin:0 auto; padding:24px; }
    header { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.06);}
    .brand { display:flex; align-items:center; gap:12px; }
    .logo { width:60px; height:60px; border-radius:50%; background:linear-gradient(135deg,#3bc9db,#4ade80); display:flex; align-items:center; justify-content:center; font-weight:700; color:#032; font-size:22px;}
    nav a { color: rgba(255,255,255,0.65); text-decoration:none; margin-left:16px; font-weight:500; }
    nav a:hover { color:#4ade80; }

    h2 { color:#4ade80; margin-bottom:20px; }
    .contact-grid { display:grid; grid-template-columns:1fr 1fr; gap:40px; margin-top:40px; }
    .contact-info { display:flex; flex-direction:column; gap:16px; }
    .contact-info div { background: rgba(255,255,255,0.06); padding:20px; border-radius:16px; }
    .contact-info div h3 { margin-bottom:8px; color:#3bc9db; }
    .contact-info div p { margin:0; color:#e6f0f6; }
    .contact-form { background: rgba(255,255,255,0.06); padding:28px; border-radius:16px; backdrop-filter: blur(8px); }
    .contact-form input, .contact-form textarea { width:100%; padding:12px; margin-bottom:16px; border:none; border-radius:12px; background:rgba(255,255,255,0.1); color:#e6f0f6; }
    .contact-form input::placeholder, .contact-form textarea::placeholder { color:#ccc; }
    .contact-form button { background:linear-gradient(90deg,#3bc9db,#4ade80); color:#032; padding:12px 18px; border:none; border-radius:12px; cursor:pointer; font-weight:700; }
    .map { margin-top:40px; border-radius:16px; overflow:hidden; height:300px; }
    footer { text-align:center; padding:20px 0; margin-top:40px; color: rgba(255,255,255,0.65); border-top:1px solid rgba(255,255,255,0.06);}
    @media(max-width:900px){ .contact-grid{grid-template-columns:1fr;} }
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
        <a href="service.php">Services</a>
        <a href="contact.php">Contact</a>
      </nav>
    </header>

    <section class="contact-grid">
      <div class="contact-info">
        <div>
          <h3>Address</h3>
          <p>Manpur, Gaya, Bihar, 823003</p>
        </div>
        <div>
          <h3>Email</h3>
          <p>ceo@homeservice.com</p>
          <p>laxman@homeservice.com</p>
            <p>kush@homeservice.com</p>
            
        </div>
        <div>
          <h3>Phone</h3>
          <p>+91 8709692411</p>
          <p>+91 9142066989</p>
          <p><strong>Working Hours:</strong> Mon-Sat, 9:00 AM - 7:00 PM</p>
        </div>
      </div>

      <div class="contact-form">
        <h2>Send Us a Message</h2>
        <form action="contact_process.php" method="POST">
          <input type="text" name="name" placeholder="Your Name" required>
          <input type="email" name="email" placeholder="Your Email" required>
          <input type="text" name="subject" placeholder="Subject" required>
          <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>
    </section>

    <section class="map">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29457.261200000003!2d85.0219644!3d24.7886422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1694960400000!5m2!1sen!2sin" 
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </section>

    <footer>
      &copy; <?php echo date('Y'); ?> Home Service Provider — Created by Kush Kumar && Laxman Kumar Chaudhary
    </footer>
  </div>
</body>
</html>
