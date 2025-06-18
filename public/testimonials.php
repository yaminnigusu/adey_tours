<?php
$page_title='Testimonials';
include('../includes/header.php');
include('../config/database.php');
$tests = $pdo->query("SELECT customer_name, message, photo_path FROM testimonials WHERE approved=1 ORDER BY submitted_at DESC")->fetchAll();
?>
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="mb-4 text-center">What Our Clients Say</h2>
    <div class="row g-4 justify-content-center">
      <?php foreach($tests as $t): ?>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm p-4 text-center">
            <?php if($t['photo_path']): ?>
              <img src="/uploads/testimonials/<?= $t['photo_path'] ?>" class="rounded-circle mb-3" width="100">
            <?php endif; ?>
            <p class="fst-italic">“<?= htmlspecialchars($t['message']) ?>”</p>
            <h6 class="fw-bold"><?= htmlspecialchars($t['customer_name']) ?></h6>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php include('../includes/footer.php'); ?>
