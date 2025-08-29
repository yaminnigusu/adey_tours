<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?? 'Adey Ethiopia Tour' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body { 
    scroll-behavior: smooth; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  /* Navbar Gradient: yellow to dark yellow */
  .navbar {
    background: linear-gradient(90deg, #ffd700, #e0a800); /* yellow to dark yellow */
  }

  .navbar-brand { 
    font-weight: bold; 
    color: #fff; 
    display: flex; 
    align-items: center; 
  }

  .navbar-brand img { 
    height: 45px; 
    margin-right: 10px; 
  }

  .nav-link {
    color: #fff;
    transition: color 0.3s ease;
  }

  .nav-link:hover { 
    color: #fff8c6 !important; /* lighter yellow on hover */
  }

  .nav-link.btn {
    background-color: #fff8c6;
    color: #e0a800;
    font-weight: bold;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

  .nav-link.btn:hover {
    background-color: #e0a800;
    color: #fff;
  }

  /* Hero Section */
  
  
  .hero .overlay { 
    position:absolute; inset:0; 
    background: rgba(0,0,0,0.4); 
  }
  
  .hero .content { 
    position: relative; 
    color: #fff; 
    top:50%; 
    transform: translateY(-50%); 
    text-align:center; 
  }

  /* Footer */
  footer { 
    background:#343a40; 
    color:#aaa; 
    padding:40px 0; 
  }

  /* Primary color theme for buttons, links etc */
  .btn-primary {
    background-color: #ffd700;
    border-color: #e0a800;
    color: #333;
  }

  .btn-primary:hover {
    background-color: #e0a800;
    border-color: #c99f00;
    color: #fff;
  }

  h1, h2, h3, h4, h5, h6 {
    color: #e0a800; /* headings match dark yellow */
  }
</style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
  <div class="container">
    <!-- LOGO + Brand -->
    <a class="navbar-brand" href="/">
      <img src="../assets/images/adeylogo.jpg" alt="Adey Tours Logo"> <!-- your logo path -->
      Adey Ethiopia Tours
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation Links -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../public/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/attractions.php">Attractions</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/tour-packages.php">Tour Packages</a></li>
        <li class="nav-item"><a class="nav-link" href="../public/blog.php">Blog</a></li>
        
        
      </ul>
    </div>
  </div>
</nav>
