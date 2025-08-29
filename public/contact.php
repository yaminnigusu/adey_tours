<?php
$page_title = 'Contact';
include('../includes/header.php');
?>

<!-- Contact Section -->
<section class="container py-5">
  <h2 class="mb-5 text-center fw-bold">Get in Touch</h2>

  <div class="row justify-content-center">
    <!-- Contact Form -->
    <div class="col-md-8">
      <div class="card shadow-sm border-0 p-4">
        <form method="POST" action="submit_contact.php">
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name *</label>
            <input id="name" name="name" class="form-control" placeholder="Your Full Name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email *</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="you@example.com" required>
          </div>

          <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Message *</label>
            <textarea id="message" name="message" rows="6" class="form-control" placeholder="Write your message here..." required></textarea>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-envelope-fill me-2"></i>Send Message</button>
          </div>
        </form>

        <hr class="my-4">

        <!-- WhatsApp Contact -->
        <div class="text-center">
          <a href="https://wa.me/2519XXXXXXX" class="btn btn-success btn-lg">
            <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
          </a>
        </div>
      </div>
    </div>

    <!-- Optional Contact Info Sidebar -->
    <div class="col-md-4 mt-4 mt-md-0">
      <div class="card shadow-sm border-0 p-4 h-100">
        <h5 class="fw-bold mb-3">Contact Info</h5>
        <p><i class="bi bi-geo-alt-fill me-2"></i> Addis Ababa, Ethiopia</p>
        <p><i class="bi bi-telephone-fill me-2"></i> +251 9XXXXXXXX</p>
        <p><i class="bi bi-envelope-fill me-2"></i> info@example.com</p>
        <p><i class="bi bi-clock-fill me-2"></i> Mon - Fri: 9:00 AM - 6:00 PM</p>
      </div>
    </div>
  </div>
</section>

<style>
/* Optional: Enhance hover effect on buttons */
.btn-primary:hover {
  background-color: #0d6efdcc;
}

.btn-success:hover {
  background-color: #198754cc;
}

/* Card Shadow Enhancement */
.card {
  border-radius: 1rem;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
</style>

<?php include('../includes/footer.php'); ?>
