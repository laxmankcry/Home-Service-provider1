<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Service Provider — Premium Look</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin:0;
      background: radial-gradient(circle at 30% 20%, #0a162c, #040b16);
      color: #e6f0f6;
      min-height:100vh;
    }
    .wrap { max-width:1180px; margin:0 auto; padding:24px; }
    header { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.06);}
    .brand { display:flex; align-items:center; gap:12px; }
    .logo { width:60px; height:60px; border-radius:50%; background:linear-gradient(135deg,#3bc9db,#4ade80); display:flex; align-items:center; justify-content:center; font-weight:700; color:#032; font-size:22px;}
    nav a { color: rgba(255,255,255,0.65); text-decoration:none; margin-left:16px; font-weight:500; }
    nav a:hover { color:#4ade80; }

    .hero {display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:40px;}
    .hero-card { background: rgba(255,255,255,0.06); padding:30px; border-radius:16px; backdrop-filter: blur(8px);}
    .hero-card h2{color:#4ade80;}
    .hero-card p{color:#ccc;}
    .hero-card .search{margin-top:15px;display:flex;gap:10px;}
    .hero-card input,.hero-card select{flex:1;padding:12px;border:none;border-radius:12px;background:rgba(255,255,255,0.1);color:#e6f0f6;}
    .hero-card input::placeholder{color:#ccc;}
    .hero-card select option{background:#0a162c;color:#e6f0f6;}
    .hero-card button{padding:12px 18px;background:linear-gradient(90deg,#3bc9db,#4ade80);border:none;border-radius:12px;color:#032;cursor:pointer;font-weight:700;}
    .illustration h3{color:#3bc9db;}
    .illustration ul{padding-left:20px;font-size:14px;color:#ccc;}

    #services h2{text-align:center;margin-top:40px;color:#4ade80;}
    .services-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin:20px;padding:0;}
    .service-card{background:rgba(255,255,255,0.06);border-radius:16px;padding:15px;text-align:center;transition:.3s;backdrop-filter:blur(8px);text-decoration:none;display:block;}
    .service-card img{width:100%;height:140px;object-fit:cover;border-radius:12px;margin-bottom:10px;}
    .service-card h3{margin:10px 0 5px;color:#4ade80;}
    .service-card p{font-size:14px;color:#ccc;}
    .service-card:hover{transform:translateY(-5px);box-shadow:0 6px 15px rgba(0,0,0,0.3);}

    footer{text-align:center;padding:20px 0;margin-top:40px;color:rgba(255,255,255,0.65);border-top:1px solid rgba(255,255,255,0.06);}
    @media(max-width:900px){ .hero{grid-template-columns:1fr;} }
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

    <section class="hero">
      <div class="hero-card">
        <h2>Book a technician in minutes</h2>
        <p>Electrician, Plumber, Mobile Repair — verified professionals, transparent pricing and easy scheduling.</p>
        <div class="search">
          <!-- single input with datalist (dropdown) -->
          <input list="serviceOptions" id="searchInput" placeholder="Search or select service">
          <datalist id="serviceOptions">
            <option value="Electrician">
            <option value="Plumber">
            <option value="Mobile Repair">
            <option value="Carpentry">
            <option value="Cleaning">
            <option value="AC Repair">
          </datalist>
          <button id="searchBtn">Search</button>
        </div>
      </div>
      <aside class="illustration">
        <h3>Why choose us?</h3>
        <ul class="small">
          <li>Background-checked technicians</li>
          <li>On-time arrival guarantee</li>
          <li>Easy rescheduling & support</li>
        </ul>
      </aside>
    </section>

    <section id="services">
      <h2>Our Services</h2>
      <div class="services-grid" id="servicesGrid"></div>
    </section>

    <footer>
      &copy; <span id="year"></span> Home Service Provider — Created by Kush Kumar && Laxman Kumar Chaudhary
    </footer>
  </div>

<script>
  // automatic year
  document.getElementById('year').textContent = new Date().getFullYear();

  const services = [
    {name:"Electrician",description:"Fast and reliable electrical services at your home.",image:"electrician.png", link:"book_service.php?service=Electrician"},
    {name:"Plumber",description:"Expert plumbing solutions with transparent pricing.",image:"plumber.png", link:"book_service.php?service=Plumber"},
    {name:"Mobile Repair",description:"Certified technicians to repair your mobile devices.",image:"mobile.png", link:"book_service.php?service=Mobile Repair"},
    {name:"Carpentry",description:"Skilled carpenters for home and office furniture.",image:"carpainter.png", link:"book_service.php?service=Carpenter"},
    {name:"Cleaning",description:"Professional home cleaning services for every corner.",image:"cleaner.png", link:"book_service.php?service=Cleaning Services"},
    {name:"AC Repair",description:"Quick and efficient AC servicing and repair at your doorstep.",image:"ac.png", link:"book_service.php?service=AC Repair"}
  ];

  const servicesGrid=document.getElementById("servicesGrid");
  const searchInput=document.getElementById("searchInput");
  const searchBtn=document.getElementById("searchBtn");

  function displayServices(list){
    servicesGrid.innerHTML="";
    if(list.length===0){
      servicesGrid.innerHTML=`<p style="grid-column:1/-1;text-align:center;color:#ccc;">No services found</p>`;
      return;
    }
    list.forEach(service=>{
      const card=document.createElement("a"); // anchor banaya
      card.className="service-card";
      card.href=service.link;   // link set kiya
      card.innerHTML=`<img src="${service.image}" alt="${service.name}">
                      <h3>${service.name}</h3>
                      <p>${service.description}</p>`;
      servicesGrid.appendChild(card);
    });
  }
  displayServices(services);

  function filterAndDisplay(){
    const q=searchInput.value.toLowerCase();
    const filtered=services.filter(s=>s.name.toLowerCase().includes(q));
    displayServices(filtered);
  }

  searchBtn.addEventListener("click",filterAndDisplay);
  searchInput.addEventListener("input",filterAndDisplay);
</script>
</body>
</html>
