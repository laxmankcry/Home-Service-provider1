<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Our Services — Home Service Provider</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
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
        <a href="#">Services</a>
        <a href="contact.php">Contact</a>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-card">
        <h2>Our Wide Range of Services</h2>
        <p>We provide fast, reliable, and verified technicians for all your home service needs. From plumbing to electrical work, mobile repair, carpentry, and cleaning, we ensure quality service at your doorstep.</p>
      </div>
      <aside class="hero-card">
        <h3>Why Choose Our Services?</h3>
        <ul>
          <li>Background-checked professionals</li>
          <li>On-time arrival guarantee</li>
          <li>Transparent pricing & easy scheduling</li>
          <li>Reliable after-service support</li>
        </ul>
      </aside>
    </section>

    <!-- Services Grid -->
    <section class="services-grid">
      <a href="book_service.php?service=Electrician" class="card">
        <h3>Electrician</h3>
        <p>Professional electricians for home wiring, repair, and installation services.</p>
        <p><strong>Service Charge: ₹350</strong></p>
      </a>

      <a href="book_service.php?service=Plumber" class="card">
        <h3>Plumber</h3>
        <p>Expert plumbing services including leak repair, pipe installation, and bathroom fittings.</p>
        <p><strong>Service Charge: ₹350</strong></p>
      </a>

      <a href="book_service.php?service=Mobile Repair" class="card">
        <h3>Mobile Repair</h3>
        <p>Certified technicians to fix smartphones, tablets, and other electronic devices quickly.</p>
        <p><strong>Service Charge: ₹250</strong></p>
      </a>

      <a href="book_service.php?service=AC Repair" class="card">
        <h3>AC Repair</h3>
        <p>Professional AC maintenance and repair to keep your home cool and comfortable.</p>
        <p><strong>Service Charge: ₹400</strong></p>
      </a>

      <a href="book_service.php?service=Carpenter" class="card">
        <h3>Carpenter</h3>
        <p>Skilled carpenters for furniture repair, installation, and custom woodwork projects.</p>
        <p><strong>Service Charge: ₹350</strong></p>
      </a>

      <a href="book_service.php?service=Cleaning Services" class="card">
        <h3>Cleaning Services</h3>
        <p>Home and office cleaning services with experienced staff and eco-friendly products.</p>
        <p><strong>Service Charge: ₹300</strong></p>
      </a>
    </section>

    <!-- Footer -->
    <footer>
      &copy; <span id="year"></span> Home Service Provider — Created by Kush Kumar && Laxman Kumar Chaudhary
    </footer>
  </div>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
