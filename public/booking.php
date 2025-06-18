<?php
$page_title='Book a Tour';
include('../includes/header.php');
?>
<section class="hero">
  <div class="overlay"></div>
  <div class="content">
    <h2 class="mb-4">Start Your Journey</h2>
    <form method="POST" action="submit_booking.php" class="row g-3 mx-auto" style="max-width:600px;background:#fff;padding:30px;border-radius:10px;">
      <div class="col-md-6"><input name="name" class="form-control" placeholder="Name*" required></div>
      <div class="col-md-6"><input name="email" type="email" class="form-control" placeholder="Email*" required></div>
      <div class="col-md-6"><input name="date" type="date" class="form-control" required></div>
      <div class="col-md-6"><input name="tour" class="form-control" placeholder="Which Tour?"></div>
      <div class="col-12"><textarea name="message" rows="3" class="form-control" placeholder="Your Message"></textarea></div>
      <div class="col-12"><button class="btn btn-primary w-100">Submit Booking</button></div>
    </form>
  </div>
</section>
<?php include('../includes/footer.php'); ?>
