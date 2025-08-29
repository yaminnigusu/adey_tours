<?php
session_start();
include("../../includes/auth_check.php");  // Auth check
include("../../config/database.php");     // PDO connection

$title = $slug = $category = $tags = $content = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (!$title) $errors[] = "Title is required.";
    if (!$content) $errors[] = "Content is required.";

    // Auto-generate slug
    if (!$slug && $title) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
        $slug = trim($slug, '-');
    }

    // Handle featured image
    $featured_image = null;
    if (!empty($_FILES['featured_image']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['featured_image']['type'], $allowed_types)) {
            $errors[] = "Featured image must be JPG, PNG, or GIF.";
        } else {
            $ext = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
            $featured_image = uniqid() . '.' . $ext;
            $upload_dir = __DIR__ . '/../../uploads/blog_images/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $upload_path = $upload_dir . $featured_image;
            if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                $errors[] = "Failed to upload featured image.";
            }
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, category, tags, content, featured_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $category, $tags, $content, $featured_image]);
        header("Location: manage.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Blog Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; min-height: 100vh; }
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

    <!-- Sidebar desktop -->

      <?php include("../partials/sidebar.php"); ?>
    

   

    <!-- Content Area -->
    <div class="col-md-9 col-lg-10 content-area">
      <h1 class="mb-4">Add Blog Post</h1>

      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
          <label for="title" class="form-label">Title*</label>
          <input type="text" id="title" name="title" class="form-control" required value="<?= htmlspecialchars($title) ?>">
        </div>

        <div class="mb-3">
          <label for="slug" class="form-label">Slug (optional)</label>
          <input type="text" id="slug" name="slug" class="form-control" value="<?= htmlspecialchars($slug) ?>">
          <small class="text-muted">If left empty, slug will be auto-generated from title.</small>
        </div>

        <div class="mb-3">
          <label for="category" class="form-label">Category (optional)</label>
          <input type="text" id="category" name="category" class="form-control" value="<?= htmlspecialchars($category) ?>">
        </div>

        <div class="mb-3">
          <label for="tags" class="form-label">Tags (optional, comma separated)</label>
          <input type="text" id="tags" name="tags" class="form-control" value="<?= htmlspecialchars($tags) ?>">
        </div>

        <div class="mb-3">
          <label for="content" class="form-label">Content*</label>
          <textarea id="content" name="content" class="form-control" rows="8" required><?= htmlspecialchars($content) ?></textarea>
        </div>

        <div class="mb-3">
          <label for="featured_image" class="form-label">Featured Image (optional)</label>
          <input type="file" id="featured_image" name="featured_image" accept="image/*" class="form-control">
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i> Add Post</button>
        <a href="manage.php" class="btn btn-secondary"><i class="bi bi-x-circle-fill"></i> Cancel</a>
      </form>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
