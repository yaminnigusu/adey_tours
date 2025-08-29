<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $page_title ?? 'Adey Ethiopia Tour' ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color:#333; }

    /* Navbar gradient & brand */
    .navbar { background: linear-gradient(90deg,#ffd700,#e0a800); }
    .navbar-brand { color:#fff; font-weight:700; display:flex; align-items:center; }
    .navbar-brand img { height:44px; margin-right:10px; }

    .nav-link { color:#fff; transition: color .18s; }
    .nav-link:hover { color:#fff8c6 !important; }

    /* Contact button style inside nav */
    .nav-link.btn { background:#fff8c6; color:#e0a800; font-weight:700; border-radius:.35rem; }
    .nav-link.btn:hover { background:#e0a800; color:#fff; }

    /* Custom toggler: 3 bars -> X */
    .toggler-icon { display:inline-block; width:28px; height:18px; position:relative; }
    .toggler-icon span { position:absolute; left:0; right:0; height:2.5px; background:#fff; border-radius:2px; transition: transform .24s ease, opacity .18s ease, top .24s ease; }
    .toggler-icon span:nth-child(1) { top:0; }
    .toggler-icon span:nth-child(2) { top:7.75px; }
    .toggler-icon span:nth-child(3) { top:15.5px; }

    /* When open (class 'open' on button) transform into X */
    .navbar-toggler.open .toggler-icon span:nth-child(1) { transform: rotate(45deg); top:7.75px; }
    .navbar-toggler.open .toggler-icon span:nth-child(2) { opacity:0; transform: scaleX(.1); }
    .navbar-toggler.open .toggler-icon span:nth-child(3) { transform: rotate(-45deg); top:7.75px; }

    .navbar-toggler { padding:.25rem .5rem; border:none; }

    @media (max-width: 991px) {
      .navbar-nav { text-align:center; margin-top:.5rem; }
      .navbar-nav .nav-item { margin-bottom:.25rem; }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/adey_tours/public/index.php">
      <img src="/adey_tours/assets/images/adeylogo.jpg" alt="Adey Logo">
      Adey Ethiopia Tours
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
            aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="toggler-icon" aria-hidden="true"><span></span><span></span><span></span></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="/adey_tours/public/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/adey_tours/public/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="/adey_tours/public/attractions.php">Attractions</a></li>
        <li class="nav-item"><a class="nav-link" href="/adey_tours/public/tour-packages.php">Tour Packages</a></li>
        <li class="nav-item"><a class="nav-link" href="/adey_tours/public/blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link btn d-lg-inline-block mt-2 mt-lg-0" href="/adey_tours/public/contact.php">Contact Us</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap bundle (includes Collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const navMenu = document.getElementById('navMenu');
  const toggler = document.querySelector('.navbar-toggler');

  // Get existing bootstrap Collapse instance (or create it)
  const bsCollapse = bootstrap.Collapse.getOrCreateInstance(navMenu, {toggle:false});

  // Update toggler visual state after Bootstrap finishes opening/closing
  navMenu.addEventListener('shown.bs.collapse', () => toggler.classList.add('open'));
  navMenu.addEventListener('hidden.bs.collapse', () => toggler.classList.remove('open'));

  // Collapse on nav link click (mobile only)
  navMenu.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      // only collapse when toggler visible (mobile)
      if (window.getComputedStyle(toggler).display !== 'none' && navMenu.classList.contains('show')) {
        bsCollapse.hide();
      }
    });
  });

  // Collapse on outside click
  document.addEventListener('click', (e) => {
    // if not open, nothing to do
    if (!navMenu.classList.contains('show')) return;

    // ignore clicks inside menu or on toggler
    if (navMenu.contains(e.target) || toggler.contains(e.target)) return;

    bsCollapse.hide();
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navMenu.classList.contains('show')) bsCollapse.hide();
  });
});
</script>

</body>
</html>
