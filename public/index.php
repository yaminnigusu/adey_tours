<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Home - Adey Tours</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- Responsive Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
  .hero {
    background: url('/adey_tours/assets/images/hero.jpg') center/cover no-repeat;
    height: 70vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
  }

  .hero .overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .hero .content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 0 20px;
  }

  .hero h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 1rem;
  }

  .hero p.lead {
    font-size: 1.25rem;
    margin-bottom: 2rem;
  }

  .hero .btn {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
  }

  @media (max-width: 768px) {
    .hero {
      height: 60vh;
    }
    .hero h1 {
      font-size: 2rem;
    }
    .hero p.lead {
      font-size: 1rem;
    }
  }
</style>
</head>
<body>
    <?php $page_title = 'Home'; include('../includes/header.php'); ?>
<section class="hero">
  <div class="overlay"></div>
  <div class="content">
    <h1 class="display-4">Discover Ethiopia With Us</h1>
    <p class="lead">Guided adventures, best prices, unforgettable experiences.</p>
    <a href="booking.php" class="btn btn-lg btn-primary me-2">Book a Tour</a>
    <a href="gallery.php" class="btn btn-lg btn-outline-light">Explore Gallery</a>
  </div>
</section>



<!-- Featured Tours Section -->
<section class="container py-5">
  <h2 class="mb-4 text-center">Featured Tours</h2>
  <div class="row g-4">
    <!-- Tour Card 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <img src="../assets/images/adey3.jpg" class="card-img-top" alt="Tour 1">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Addis City Highlights</h5>
          <p class="card-text flex-grow-1">Explore the heart of Ethiopia's capital.</p>
          <a href="booking.php" class="btn btn-primary mt-auto">Book Now</a>
        </div>
      </div>
    </div>
    <!-- You can duplicate this block for more tours -->
  </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="mb-4 text-center">Why Choose Us</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <i class="bi bi-award display-3 text-primary"></i>
        <h5 class="mt-3">Expert Guides</h5>
        <p>Certified local guides with deep knowledge of Ethiopia's hidden gems.</p>
      </div>
      <div class="col-md-4 mb-4">
        <i class="bi bi-star display-3 text-primary"></i>
        <h5 class="mt-3">5-Star Ratings</h5>
        <p>Loved and rated highly by travelers from around the world.</p>
      </div>
      <div class="col-md-4 mb-4">
        <i class="bi bi-geo-alt display-3 text-primary"></i>
        <h5 class="mt-3">Authentic Locations</h5>
        <p>Handpicked tours that immerse you in culture and adventure.</p>
      </div>
    </div>
  </div>
</section>

<?php include('../includes/footer.php'); ?>

<!-- Bootstrap JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
