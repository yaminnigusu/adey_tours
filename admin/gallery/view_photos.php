<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

$gallery_id = $_GET['gallery_id'] ?? null;
if (!$gallery_id) {
    die("Gallery ID is required.");
}

// Handle photo deletion if requested
if (isset($_GET['delete_photo_id'])) {
    $delete_photo_id = intval($_GET['delete_photo_id']);

    // Get the filename for the photo to delete
    $stmt = $pdo->prepare("SELECT filename FROM photos WHERE id = ? AND gallery_id = ?");
    $stmt->execute([$delete_photo_id, $gallery_id]);
    $photo = $stmt->fetch();

    if ($photo) {
        // Delete the file from the server
        $file_path = __DIR__ . '/../../uploads/gallery_photos/' . $photo['filename'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the DB record
        $stmt = $pdo->prepare("DELETE FROM photos WHERE id = ?");
        $stmt->execute([$delete_photo_id]);

        // Redirect to avoid resubmission
        header("Location: view_photos.php?gallery_id=" . urlencode($gallery_id));
        exit;
    } else {
        $error = "Photo not found or does not belong to this gallery.";
    }
}

// Fetch gallery info
$stmt = $pdo->prepare("SELECT * FROM galleries WHERE id = ?");
$stmt->execute([$gallery_id]);
$gallery = $stmt->fetch();

if (!$gallery) {
    die("Gallery not found.");
}

// Fetch photos for this gallery
$stmt = $pdo->prepare("SELECT * FROM photos WHERE gallery_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$gallery_id]);
$photos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Photos in <?= htmlspecialchars($gallery['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .photo-thumb {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .photo-thumb:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php include("../partials/navbar.php"); ?>

<div class="container mt-4">
    <h1>Photos in "<?= htmlspecialchars($gallery['title']) ?>"</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a href="upload_photo.php?gallery_id=<?= $gallery_id ?>" class="btn btn-primary mb-3">Upload New Photo</a>
    <a href="manage.php" class="btn btn-secondary mb-3">Back to Galleries</a>

    <?php if (count($photos) > 0): ?>
        <div class="row g-3">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="card position-relative">
                        <img src="<?= htmlspecialchars('/adey_tours/uploads/gallery_photos/' . $photo['filename']) ?>" alt="Photo" class="photo-thumb card-img-top" />
                        <div class="card-body p-2 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Uploaded: <?= date('Y-m-d H:i', strtotime($photo['uploaded_at'])) ?></small>
                            <a href="view_photos.php?gallery_id=<?= $gallery_id ?>&delete_photo_id=<?= $photo['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this photo?');"
                               title="Delete Photo">
                               &times;
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No photos uploaded yet for this album.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
