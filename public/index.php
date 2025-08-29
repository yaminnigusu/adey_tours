<?php $page_title = 'Home'; include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Home - Adey Tours</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: #333;
      scroll-behavior: smooth;
    }

    /* Hero Carousel */
    .carousel-item {
      height: 90vh;
    }
    .carousel-item img {
      object-fit: cover;
      height: 100%;
      width: 100%;
    }
    .carousel-caption {
      bottom: 25%;
      text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
    }
    .carousel-caption h1 {
      font-size: 3.5rem;
      font-weight: 700;
    }
    .carousel-caption p {
      font-size: 1.3rem;
      margin-bottom: 1.5rem;
    }

    /* Info Cards */
    .why-card, .card {
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    .why-card:hover, .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    .why-card i {
      font-size: 3rem;
      color: #0d6efd;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../assets/images/hero.jpg" class="d-block w-100" alt="Slide 1">
      <div class="carousel-caption d-none d-md-block">
        <h1>Discover Ethiopia With Us</h1>
        <p>Guided adventures, best prices, unforgettable experiences.</p>
        <a href="booking.php" class="btn btn-primary btn-lg me-2">Book a Tour</a>
        <a href="attractions.php" class="btn btn-outline-light btn-lg">Explore Attractions</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../assets/images/adey123.jpg" class="d-block w-100" alt="Slide 2">
      <div class="carousel-caption d-none d-md-block">
        <h1>Experience Breathtaking Landscapes</h1>
        <p>From mountains to historical sites, Ethiopia has it all.</p>
        <a href="booking.php" class="btn btn-primary btn-lg me-2">Book a Tour</a>
        <a href="attractions.php" class="btn btn-outline-light btn-lg">Explore Attractions</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../assets/images/hero.jpg" class="d-block w-100" alt="Slide 3">
      <div class="carousel-caption d-none d-md-block">
        <h1>Unforgettable Cultural Adventures</h1>
        <p>Immerse yourself in Ethiopia’s rich heritage and traditions.</p>
        <a href="booking.php" class="btn btn-primary btn-lg me-2">Book a Tour</a>
        <a href="attractions.php" class="btn btn-outline-light btn-lg">Explore Attractions</a>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>

  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
  </div>
</div>

<!-- Info Section -->
<section class="container py-5">
  <div class="row g-4 text-center">
    <div class="col-md-4">
      <div class="why-card h-100">
        <i class="bi bi-people"></i>
        <h5>Who We Are</h5>
        <p>Senait Ethiopia Tours is Ethiopian owned tour company operating since 2008, offering wide selections of tour packages.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="why-card h-100">
        <i class="bi bi-truck"></i>
        <h5>Vehicles</h5>
        <p>Excellent condition cars suitable for different group sizes, road conditions, and tour activities.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="why-card h-100">
        <i class="bi bi-camera-reels"></i>
        <h5>Photography & Filming</h5>
        <p>Reliable partner for documentary filming and photography tours in Ethiopia.</p>
      </div>
    </div>
  </div>

  <div class="row g-4 text-center mt-3">
    <div class="col-md-4">
      <div class="why-card h-100">
        <i class="bi bi-gear"></i>
        <h5>Our Services</h5>
        <p>Specialists in customized itineraries, group tours, family holidays, and independent vacations.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="why-card h-100">
        <i class="bi bi-card-checklist"></i>
        <h5>Registration & License</h5>
        <p>Registered and licensed by Ethiopia’s Ministry of Trade and Industry under license No. 14/673/35706/2004.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="why-card h-100">
        <i class="bi bi-cash-coin"></i>
        <h5>Cost Effectiveness</h5>
        <p>No hidden costs or late pricing surprises. Know exactly what you are getting for your money.</p>
      </div>
    </div>
  </div>
</section>

<?php
include("../config/database.php"); // Make sure your PDO connection is correct

// Fetch all attractions
$stmt = $pdo->query("SELECT * FROM attractions ORDER BY id DESC");
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="container py-5">
  <h2 class="text-center mb-4">Attractions Overview</h2>
  <div class="row g-4">
    <?php if ($attractions): ?>
      <?php foreach ($attractions as $attr): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0">
            <?php if ($attr['image'] && file_exists("../uploads/attractions/".$attr['image'])): ?>
              <img src="../uploads/attractions/<?= htmlspecialchars($attr['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($attr['title']) ?>">
            <?php else: ?>
              <img src="assets/images/default.jpg" class="card-img-top" alt="<?= htmlspecialchars($attr['title']) ?>">
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


<!-- Why Choose Us -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center">Why Choose Us</h2>
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="why-card">
          <i class="bi bi-award"></i>
          <h5>Expert Guides</h5>
          <p>Certified local guides with deep knowledge of Ethiopia's hidden gems.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="why-card">
          <i class="bi bi-star"></i>
          <h5>5-Star Ratings</h5>
          <p>Loved and rated highly by travelers from around the world.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="why-card">
          <i class="bi bi-geo-alt"></i>
          <h5>Authentic Locations</h5>
          <p>Handpicked tours that immerse you in culture and adventure.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('../includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
