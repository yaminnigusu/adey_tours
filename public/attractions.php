<?php 
$page_title = 'Attractions'; 
include('../includes/header.php'); 
include('../config/database.php'); // PDO connection
?>

<!-- Hero Section -->
<section class="hero" style="background: url('../assets/images/adey123.jpg') center/cover no-repeat; height: 70vh; position: relative;">
  <div class="overlay" style="position:absolute; inset:0; background: rgba(0,0,0,0.4);"></div>
  <div class="content" style="position: relative; color: #fff; top:50%; transform: translateY(-50%); text-align:center;">
    <h1 class="display-4 fw-bold">Explore Ethiopia's Attractions</h1>
    <p class="lead">Discover historic sites, breathtaking landscapes, and unique cultural experiences.</p>
    <a href="tour-packages.php" class="btn btn-primary btn-lg me-2">View Tour Packages</a>
  </div>
</section>

<?php
// Fetch all attractions from database
$stmt = $pdo->query("SELECT * FROM attractions ORDER BY id DESC");
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Attractions Overview -->
<section class="container py-5">
  <h2 class="text-center mb-5">Explore Attractions</h2>
  <div class="row g-4">
    <?php if ($attractions): ?>
      <?php foreach ($attractions as $attr): ?>
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <?php if ($attr['image'] && file_exists("../uploads/attractions/" . $attr['image'])): ?>
              <img src="../uploads/attractions/<?= htmlspecialchars($attr['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($attr['title']) ?>">
            <?php else: ?>
              <img src="../assets/images/default.jpg" class="card-img-top" alt="<?= htmlspecialchars($attr['title']) ?>">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($attr['title']) ?></h5>
              <p class="card-text"><?= htmlspecialchars(substr($attr['description'],0,150)) ?><?= strlen($attr['description'])>150 ? '...' : '' ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">No attractions available at the moment.</p>
    <?php endif; ?>
  </div>
</section>

<?php include('../includes/footer.php'); ?>
