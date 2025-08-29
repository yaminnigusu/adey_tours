<!-- Sidebar & Toggle Button -->
 <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 </head>
<nav class="d-md-none navbar navbar-dark sticky-top" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <span class="navbar-brand ms-2 text-dark">Admin Panel</span>
  </div>
</nav>

<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar">
  <div class="offcanvas-header" style="background: linear-gradient(135deg, #ffc107, #ff9800); color:#343a40;">
    <h5 class="offcanvas-title">Admin Panel</h5>
    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body p-0">
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link text-dark mb-1" href="/adey_tours/public/index.php"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a></li>
      <li class="nav-item"><a class="nav-link text-dark mb-1" href="/adey_tours/admin/gallery/manage.php"><i class="bi bi-image me-2"></i> Gallery</a></li>
      <li class="nav-item"><a class="nav-link text-dark mb-1 active" href="/adey_tours/admin/attractions/manage.php"><i class="bi bi-map me-2"></i> Attractions</a></li>
      <li class="nav-item"><a class="nav-link text-dark mb-1" href="/adey_tours/admin/blog/manage.php"><i class="bi bi-journal-text me-2"></i> Blog Posts</a></li>
      <li class="nav-item"><a class="nav-link text-dark mb-1" href="/adey_tours/admin/testimonials/manage.php"><i class="bi bi-chat-left-quote me-2"></i> Testimonials</a></li>
      <li class="nav-item"><a class="nav-link text-dark mb-1" href="/adey_tours/admin/ratings/view_all.php"><i class="bi bi-star-fill me-2"></i> Ratings</a></li>
      <li class="nav-item"><a class="nav-link text-dark mb-1" href="/adey_tours/admin/contact/messages.php"><i class="bi bi-envelope-fill me-2"></i> Contact Messages</a></li>
    </ul>
  </div>
</div>

<!-- Sidebar for larger screens -->
<div class="col-md-3 col-lg-2 d-none d-md-block sidebar">
    <div class="position-sticky pt-3">
        <h5 class="px-3 mb-3" style="color: #ff9800;">Admin Panel</h5>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link mb-1" href="/adey_tours/admin/index.php"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link mb-1" href="/adey_tours/admin/gallery/manage.php"><i class="bi bi-image me-2"></i> Gallery</a></li>
            <li class="nav-item"><a class="nav-link mb-1 active" href="/adey_tours/admin/attractions/manage.php"><i class="bi bi-map me-2"></i> Attractions</a></li>
            <li class="nav-item"><a class="nav-link mb-1" href="/adey_tours/admin/blog/manage.php"><i class="bi bi-journal-text me-2"></i> Blog Posts</a></li>
            <li class="nav-item"><a class="nav-link mb-1" href="/adey_tours/admin/testimonials/manage.php"><i class="bi bi-chat-left-quote me-2"></i> Testimonials</a></li>
            <li class="nav-item"><a class="nav-link mb-1" href="/adey_tours/admin/ratings/view_all.php"><i class="bi bi-star-fill me-2"></i> Ratings</a></li>
            <li class="nav-item"><a class="nav-link mb-1" href="/adey_tours/admin/contact/messages.php"><i class="bi bi-envelope-fill me-2"></i> Contact Messages</a></li>
        </ul>
    </div>
</div>

<style>
/* Sidebar styling */
.sidebar {
    min-height: 100vh;
    background: linear-gradient(180deg, #343a40 0%, #495057 100%);
    padding-top: 1rem;
}
.sidebar h5 {
    font-weight: bold;
}
.sidebar .nav-link {
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease-in-out;
    color: #ffc107;
}
.sidebar .nav-link:hover {
    background-color: #ffc107;
    color: #343a40;
}

.sidebar .nav-link i {
    font-size: 1.1rem;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
