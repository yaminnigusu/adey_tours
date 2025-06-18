<?php
session_start();
include("../includes/auth_check.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Adey Ethiopia Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>

<?php include("partials/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">
        <?php include("partials/sidebar.php"); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
            <h1 class="h3 mb-4">Welcome to Admin Dashboard</h1>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>Gallery</h5>
                            <p><a href="gallery/manage.php">Manage Photos</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>Blog</h5>
                            <p><a href="blog/manage.php">Manage Posts</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>Testimonials</h5>
                            <p><a href="testimonials/manage.php">Moderate Entries</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>Ratings</h5>
                            <p><a href="ratings/view_all.php">View Reviews</a></p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
