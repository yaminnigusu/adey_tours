<?php 
$page_title = 'Home'; 
include('../includes/header.php'); 
include("../config/database.php");

// Fetch all attractions
$stmt = $pdo->query("SELECT * FROM attractions ORDER BY id DESC");
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<section class="hero position-relative" style="background: url('../assets/images/hero.jpg') center/cover no-repeat; height: 70vh;">
    <div class="overlay position-absolute inset-0" style="background: rgba(0,0,0,0.45);"></div>
    <div class="container h-100 d-flex flex-column justify-content-center text-center text-white position-relative">
        <h1 class="display-4 fw-bold">Discover Ethiopia With Us</h1>
        <p class="lead mb-4">Guided adventures, best prices, unforgettable experiences.</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
            <a href="booking.php" class="btn btn-primary btn-lg">Book a Tour</a>
            <a href="attractions.php" class="btn btn-outline-light btn-lg">Explore Attractions</a>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US — Upgraded -->
<section class="why-section py-5">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="display-6 fw-bold mb-2">Why Choose Adey Ethiopia Tours</h2>
      <p class="text-muted mx-auto" style="max-width:720px;">
        Experience Ethiopia with trusted local guides, comfortable vehicles and tailor-made itineraries — crafted for unforgettable memories.
      </p>
    </div>

    <div class="row g-4 align-items-stretch why-grid">
      <!-- Card 1 -->
      <article class="col-12 col-md-6 col-lg-4">
        <div class="why-card" data-bg="/adey_tours/assets/images/adeylogo.jpg" tabindex="0" aria-labelledby="whoTitle">
          <div class="why-media" aria-hidden="true"></div>
          <div class="why-body">
            <div class="why-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></div>
            <h3 id="whoTitle" class="why-title">Who We Are</h3>
            <p class="why-copy">Ethiopian-owned since 2008. We craft authentic, safe and culturally immersive tours tailored to every traveler.</p>
            <a class="why-link" href="/adey_tours/public/about.php">Learn more</a>
          </div>
        </div>
      </article>

      <!-- Card 2 (center, lifted) -->
      <article class="col-12 col-md-6 col-lg-4">
        <div class="why-card why-card--featured" data-bg="/adey_tours/assets/images/why-vehicles.jpg" tabindex="0" aria-labelledby="vehTitle">
          <div class="why-media" aria-hidden="true"></div>
          <div class="why-body">
            <div class="why-icon"><i class="bi bi-truck-front-fill" aria-hidden="true"></i></div>
            <h3 id="vehTitle" class="why-title">Vehicles</h3>
            <p class="why-copy">A modern fleet maintained to the highest standards — comfortable, reliable and suited to every route.</p>
            <a class="why-link" href="/adey_tours/public/tour-packages.php">View packages</a>
          </div>
        </div>
      </article>

      <!-- Card 3 -->
      <article class="col-12 col-md-6 col-lg-4">
        <div class="why-card" data-bg="/adey_tours/assets/images/adey123.jpg" tabindex="0" aria-labelledby="photoTitle">
          <div class="why-media" aria-hidden="true"></div>
          <div class="why-body">
            <div class="why-icon"><i class="bi bi-camera-reels-fill" aria-hidden="true"></i></div>
            <h3 id="photoTitle" class="why-title">Photography & Filming</h3>
            <p class="why-copy">Documentary-ready support and local knowledge to help you capture Ethiopia’s most cinematic moments.</p>
            <a class="why-link" href="/adey_tours/public/contact.php">Get a quote</a>
          </div>
        </div>
      </article>
    </div>
  </div>

  <!-- decorative wave (optional) -->
  <svg class="why-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,30 C180,80 420,0 720,30 C1020,60 1260,20 1440,40 L1440,80 L0,80 Z" fill="#fff"></path>
  </svg>
</section>

<style>
  /* Basic variables */
  :root{
    --accent-1:#ffd700;
    --accent-2:#e0a800;
    --muted:#6c757d;
    --card-radius:16px;
  }

  /* Section root */
  .why-section{
    background: linear-gradient(180deg, rgba(224,168,0,0.06), rgba(255,215,0,0.02));
    position:relative;
    overflow:hidden;
  }
  .why-section .display-6 { color:var(--accent-2); }

  /* Grid staggering on larger screens */
  .why-grid { align-items:stretch; }
  @media(min-width:992px){
    .why-grid .col-lg-4:nth-child(2) .why-card { transform: translateY(-28px); } /* lift center */
  }

  /* Card */
  .why-card{
    position:relative;
    border-radius:var(--card-radius);
    overflow:hidden;
    min-height:320px;
    background:linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.95));
    box-shadow: 0 10px 30px rgba(20,20,20,0.08);
    transition: transform .45s cubic-bezier(.2,.9,.2,1), box-shadow .35s ease, filter .35s ease;
    display:flex;
    flex-direction:column;
    cursor:pointer;
  }

  /* Card featured */
  .why-card--featured {
    border: 2px solid rgba(224,168,0,0.12);
    background: linear-gradient(180deg, rgba(255,250,240,0.98), rgba(255,255,255,0.98));
    box-shadow: 0 18px 40px rgba(20,20,20,0.12);
  }

  /* media/background */
  .why-media{
    position:absolute;
    inset:0;
    background-position:center;
    background-size:cover;
    filter: saturate(.9) contrast(.95) brightness(.55);
    transform: scale(1.03);
    transition: transform .8s ease, filter .6s ease;
    z-index:0;
  }

  /* gradient overlay to ensure text contrast */
  .why-card::after{
    content:'';
    position:absolute;
    inset:0;
    background:linear-gradient(180deg, rgba(0,0,0,0.15), rgba(0,0,0,0.45));
    z-index:1;
    transition: background .3s ease;
  }

  /* content */
  .why-body{
    position:relative;
    z-index:2;
    padding:28px;
    margin-top:auto;
    color:#fff;
    text-align:left;
    display:flex;
    flex-direction:column;
    gap:10px;
    background: linear-gradient(180deg, rgba(0,0,0,0.0), rgba(0,0,0,0.25));
  }

  .why-icon{
    width:64px;
    height:64px;
    border-radius:14px;
    display:inline-grid;
    place-items:center;
    background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.06));
    color:#fff;
    font-size:1.5rem;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    transition: transform .35s ease, box-shadow .35s ease;
  }

  .why-title{
    font-size:1.25rem;
    margin:0;
    color:#fff;
    font-weight:700;
  }

  .why-copy{
    margin:0;
    color: rgba(255,255,255,0.92);
    line-height:1.5;
  }

  .why-link{
    display:inline-block;
    margin-top:8px;
    color:var(--accent-1);
    font-weight:600;
    text-decoration:none;
    background: rgba(255,255,255,0.12);
    padding:.45rem .8rem;
    border-radius:8px;
    width:max-content;
    transition: background .25s ease, transform .18s ease;
  }

  .why-link:hover{ transform: translateY(-3px); background: rgba(255,255,255,0.18); color:var(--accent-2); }

  /* Hover interactions (desktop) */
  @media (hover: hover) and (min-width: 768px) {
    .why-card:hover{
      transform: translateY(-12px) rotate(-0.25deg);
      box-shadow: 0 28px 60px rgba(20,20,20,0.18);
      filter: saturate(1.05);
    }
    .why-card:hover .why-media { transform: scale(1.06); filter: brightness(.6) saturate(1.05); }
    .why-card:hover .why-icon { transform: translateY(-6px) scale(1.03); box-shadow: 0 14px 40px rgba(0,0,0,0.25); }
  }

  /* Entrance animation (initial state) */
  .why-card { opacity:0; transform: translateY(24px) scale(.995); }
  .why-card.in-view { opacity:1; transform: translateY(0) scale(1); transition: all .7s cubic-bezier(.2,.9,.2,1); }

  /* Responsive tweaks */
  @media (max-width:767px){
    .why-body { padding:18px; text-align:center; align-items:center; }
    .why-title, .why-copy { color:#fff; }
    .why-icon { width:58px; height:58px; }
    .why-card { min-height:280px; border-radius:12px; }
    .why-card::after{ background:linear-gradient(180deg, rgba(0,0,0,0.25), rgba(0,0,0,0.55)); }
  }

  /* decorative wave */
  .why-wave{ position:absolute; left:0; right:0; bottom:-1px; width:100%; height:64px; display:block; }
</style>

<script>
/* Lazy background + Intersection Observer to animate in */
(function(){
  const cards = document.querySelectorAll('.why-card');

  // lazy-load backgrounds and observe for in-view
  const io = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const card = entry.target;
      const bg = card.dataset.bg;
      if (bg) {
        const media = card.querySelector('.why-media');
        // set background-image (lazy)
        media.style.backgroundImage = `url('${bg}')`;
        // small preloading: swap filter after image loads
        const img = new Image();
        img.src = bg;
        img.onload = () => media.style.transition = 'transform .8s ease, filter .6s ease';
      }
      // reveal
      card.classList.add('in-view');
      obs.unobserve(card);
    });
  }, {threshold:0.18});

  cards.forEach(c => io.observe(c));

  // close on mobile tap: remove transform tilt for touch devices (avoids conflicts)
  const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  if (isTouch) {
    cards.forEach(c => c.addEventListener('touchstart', ()=> c.classList.add('in-view')));
  }
})();
</script>


<!-- Attractions Overview -->
<section class="container py-5">
    <h2 class="text-center mb-4">Attractions Overview</h2>
    <div class="row g-4">
        <?php if ($attractions): ?>
            <?php foreach ($attractions as $attr): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if ($attr['image'] && file_exists("../uploads/attractions/".$attr['image'])): ?>
                            <img src="../uploads/attractions/<?= htmlspecialchars($attr['image']) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($attr['title']) ?>" loading="lazy">
                        <?php else: ?>
                            <img src="../assets/images/default.jpg" class="card-img-top img-fluid" alt="<?= htmlspecialchars($attr['title']) ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($attr['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($attr['description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No attractions available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Why Choose Us (Extra Section) -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Why Choose Us</h2>
        <div class="row g-4 text-center">
            <div class="col-12 col-md-4">
                <div class="why-card p-4 h-100">
                    <i class="bi bi-award mb-3"></i>
                    <h5>Expert Guides</h5>
                    <p>Certified local guides with deep knowledge of Ethiopia's hidden gems.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="why-card p-4 h-100">
                    <i class="bi bi-star mb-3"></i>
                    <h5>5-Star Ratings</h5>
                    <p>Loved and rated highly by travelers from around the world.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="why-card p-4 h-100">
                    <i class="bi bi-geo-alt mb-3"></i>
                    <h5>Authentic Locations</h5>
                    <p>Handpicked tours that immerse you in culture and adventure.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

/* Hero */
.hero { height: 70vh; background-size: cover; background-position: center; }
.hero .overlay { background: rgba(0,0,0,0.45); }

/* Cards & Info */
.card, .why-card {
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease-in-out;
}
.card:hover, .why-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}
.why-card i {
    font-size: 3rem;
    color: #0d6efd;
}

/* Responsive adjustments */
@media (max-width: 767px){
    .hero h1 { font-size: 2rem; }
    .hero p { font-size: 1rem; }
    .hero .btn { width: 100%; margin-bottom: 0.5rem; }
}
</style>

<?php include('../includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
