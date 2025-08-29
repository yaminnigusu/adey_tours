<?php
session_start();
include("../../includes/auth_check.php"); // Auth check
include("../../config/database.php");

$title = $description = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$title || !$description) {
        $error = "Title and Description are required.";
    } else {
        // Handle image upload
        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetDir = __DIR__ . '/../../uploads/attractions/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
            move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
        }

        $stmt = $pdo->prepare("INSERT INTO attractions (title, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $imageName]);

        header("Location: manage.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Attraction</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .content-area { padding: 20px; }
    .sidebar { min-height: 100vh; background: linear-gradient(180deg, #343a40 0%, #495057 100%); }
    .sidebar h5 { color: #ff9800; font-weight: bold; padding: 1rem; }
    .sidebar .nav-link { color: #ffc107; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.25rem; transition: all 0.2s; }
    .sidebar .nav-link:hover { background-color: #ffc107; color: #343a40; }
  
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    
      <?php include("../partials/sidebar.php"); ?>
    
    <!-- Content Area -->
    <div class="col-md-9 col-lg-10 content-area">
      <h1 class="mb-4">Add New Attraction</h1>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
          <label class="form-label">Title*</label>
          <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($title) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Description*</label>
          <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Image</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Attraction</button>
        <a href="manage.php" class="btn btn-secondary"><i class="bi bi-x-circle-fill"></i> Cancel</a>
      </form>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
