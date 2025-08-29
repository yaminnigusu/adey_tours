<?php $page_title='Tour Packages'; include('../includes/header.php'); ?>

<!-- Hero Section -->
<section class="hero" style="background: url('../assets/images/tour1.jpg') center/cover no-repeat; height: 70vh; position: relative;">
  <div class="overlay" style="position:absolute; inset:0; background: rgba(0,0,0,0.4);"></div>
  <div class="content" style="position: relative; color: #fff; top:50%; transform: translateY(-50%); text-align:center;">
    <h1 class="display-4 fw-bold">Our Tour Packages</h1>
    <p class="lead">Discover Ethiopia’s wonders with our tailor-made tours for all interests and durations.</p>
    <a href="contact.php" class="btn btn-primary btn-lg me-2">Book a Tour</a>
  </div>
</section>

<!-- Tour Packages Overview -->
<section class="container py-5">
  <h2 class="text-center mb-5">Popular Tours</h2>
  <div class="row g-4">

    <!-- Tour Package 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <img src="../assets/images/addis_lalibela.jpg" class="card-img-top" alt="Addis & Lalibela Tour">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Addis Ababa & Lalibela Highlights</h5>
          <p class="card-text flex-grow-1">
            7-day tour exploring the vibrant capital, historic sites, and the rock-hewn churches of Lalibela.
          </p>
          <ul class="mb-3">
            <li>Duration: 7 Days</li>
            <li>Accommodation: 4-Star Hotels</li>
            <li>Private Guided Tours</li>
          </ul>
          <a href="contact.php" class="btn btn-primary mt-auto">Book Now</a>
        </div>
      </div>
    </div>

    <!-- Tour Package 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <img src="../assets/images/gondar_simien.jpg" class="card-img-top" alt="Gondar & Simien Tour">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Gondar & Simien Mountains</h5>
          <p class="card-text flex-grow-1">
            6-day adventure to discover Gondar’s castles and trek the breathtaking Simien Mountains National Park.
          </p>
          <ul class="mb-3">
            <li>Duration: 6 Days</li>
            <li>Accommodation: 3-4 Star Hotels</li>
            <li>Professional Guides</li>
          </ul>
          <a href="contact.php" class="btn btn-primary mt-auto">Book Now</a>
        </div>
      </div>
    </div>

    <!-- Tour Package 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <img src="../assets/images/omo_valley.jpg" class="card-img-top" alt="Omo Valley Tour">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Omo Valley Cultural Expedition</h5>
          <p class="card-text flex-grow-1">
            8-day immersive experience visiting the unique tribes of Omo Valley, learning about their traditions and lifestyles.
          </p>
          <ul class="mb-3">
            <li>Duration: 8 Days</li>
            <li>Accommodation: Eco Lodges & Hotels</li>
            <li>Local Expert Guides</li>
          </ul>
          <a href="contact.php" class="btn btn-primary mt-auto">Book Now</a>
        </div>
      </div>
    </div>

    <!-- Add more packages by duplicating the col-md-4 block -->
  </div>
</section>

<!-- Custom Tour Packages Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Customized Tours</h2>
    <p class="text-center">
      We specialize in creating tailor-made itineraries to fit your interests, budget, and schedule. Whether you prefer history, adventure, culture, or nature, our team will craft a personalized experience for you.
    </p>
    <div class="text-center mt-4">
      <a href="contact.php" class="btn btn-primary btn-lg">Plan Your Custom Tour</a>
    </div>
  </div>
</section>

<?php include('../includes/footer.php'); ?>
