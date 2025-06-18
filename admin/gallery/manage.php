<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

// Fetch all galleries
$sql = "SELECT * FROM galleries ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$galleries = $stmt->fetchAll();  // fetch all rows as associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Manage Galleries - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container-fluid">
    <div class="row">
        <?php include("../partials/sidebar.php"); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
            <h1>Photo Galleries</h1>
            <a href="add_album.php" class="btn btn-success mb-3">Add New Album</a>

            <?php if (count($galleries) > 0): ?>
                <div class="row">
                    <?php foreach ($galleries as $gallery): ?>
                        <div class="col-md-4">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($gallery['title']) ?></h5>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($gallery['description'])) ?></p>
                                    <a href="upload_photo.php?gallery_id=<?= $gallery['id'] ?>" class="btn btn-primary btn-sm">Upload Photos</a>
                                    <a href="view_photos.php?gallery_id=<?= $gallery['id'] ?>" class="btn btn-info btn-sm">View Photos</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No galleries found. Create one now.</p>
            <?php endif; ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
