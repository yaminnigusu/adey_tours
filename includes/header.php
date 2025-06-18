<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?? 'Adey Ethiopia Tour' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { scroll-behavior: smooth; }
    .navbar-brand { font-weight: bold; color: #2c3e50; }
    .nav-link:hover { color: #007bff !important; }
    .hero { background: url('/assets/images/hero.jpg') center/cover no-repeat; height: 70vh; position: relative; }
    .hero .overlay { position:absolute; inset:0; background: rgba(0,0,0,0.4); }
    .hero .content { position: relative; color: #fff; top:50%; transform: translateY(-50%); text-align:center; }
    footer { background:#343a40; color:#aaa; padding:40px 0; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/">Adey Ethiopia Tours</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../public/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/gallery.php">Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/testimonials.php">Testimonials</a></li>
        <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2" href="../public/contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
