<?php
$page_title='Contact';
include('includes/header.php');
?>
<section class="container py-5">
  <h2 class="mb-4 text-center">Get in Touch</h2>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form method="POST" action="submit_contact.php">
        <div class="mb-3">
          <label>Name *</label>
          <input name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Email *</label>
          <input name="email" type="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Message *</label>
          <textarea name="message" rows="5" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary">Send Message</button>
      </form>
      <a href="https://wa.me/2519XXXXXXX" class="btn btn-success mt-3"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
    </div>
  </div>
</section>
<?php include('includes/footer.php'); ?>
