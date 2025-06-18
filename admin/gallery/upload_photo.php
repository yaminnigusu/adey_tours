<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

$gallery_id = $_GET['gallery_id'] ?? null;
if (!$gallery_id) {
    die("Gallery ID is required.");
}

// Check if gallery exists
$stmt = $pdo->prepare("SELECT * FROM galleries WHERE id = ?");
$stmt->execute([$gallery_id]);
$gallery = $stmt->fetch();

if (!$gallery) {
    die("Gallery not found.");
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['photo']['name'])) {
        $file = $_FILES['photo'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB max size

        if (in_array($file['type'], $allowed_types)) {
            if ($file['size'] <= $max_size) {
                // Create uploads folder if not exists
                $upload_dir = __DIR__ . '/../../uploads/gallery_photos/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Generate unique filename
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('photo_') . '.' . $ext;
                $target_path = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    // Save photo info to DB
                    $stmt = $pdo->prepare("INSERT INTO photos (gallery_id, filename, uploaded_at) VALUES (?, ?, NOW())");
                    if ($stmt->execute([$gallery_id, $filename])) {
                        $success = "Photo uploaded successfully.";
                    } else {
                        $error = "Failed to save photo info to database.";
                        unlink($target_path); // Remove uploaded file if DB insert fails
                    }
                } else {
                    $error = "Failed to move uploaded file.";
                }
            } else {
                $error = "File size exceeds 5MB limit.";
            }
        } else {
            $error = "Invalid file type. Allowed types: JPG, PNG, GIF.";
        }
    } else {
        $error = "Please select a photo to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Upload Photo - <?= htmlspecialchars($gallery['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include("../partials/navbar.php"); ?>

<div class="container mt-4">
    <h1>Upload Photo to "<?= htmlspecialchars($gallery['title']) ?>"</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
            <label for="photo" class="form-label">Select Photo (JPG, PNG, GIF, max 5MB)</label>
            <input type="file" name="photo" id="photo" class="form-control" required accept=".jpg,.jpeg,.png,.gif" />
        </div>
        <button type="submit" class="btn btn-primary">Upload Photo</button>
        <a href="manage.php" class="btn btn-secondary">Back to Galleries</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
