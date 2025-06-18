<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch existing post
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: manage.php");
    exit;
}

$errors = [];
$title = $post['title'];
$slug = $post['slug'];
$category = $post['category'];
$tags = $post['tags'];
$content = $post['content'];
$featured_image = $post['featured_image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (!$title) {
        $errors[] = "Title is required.";
    }
    if (!$content) {
        $errors[] = "Content is required.";
    }

    if (!$slug && $title) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
        $slug = trim($slug, '-');
    }

    // Handle new image upload if any
    if (!empty($_FILES['featured_image']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['featured_image']['type'], $allowed_types)) {
            $errors[] = "Featured image must be JPG, PNG, or GIF.";
        } else {
            $ext = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
            $new_image = uniqid() . '.' . $ext;
            $upload_dir = __DIR__ . '/../../uploads/blog_images/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $upload_path = $upload_dir . $new_image;
            if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                $errors[] = "Failed to upload featured image.";
            } else {
                // Delete old image file if exists
                if ($featured_image && file_exists($upload_dir . $featured_image)) {
                    unlink($upload_dir . $featured_image);
                }
                $featured_image = $new_image;
            }
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, category = ?, tags = ?, content = ?, featured_image = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$title, $slug, $category, $tags, $content, $featured_image, $id]);
        header("Location: manage.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Blog Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container mt-4">
  <h1>Edit Blog Post</h1>

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
      <?php if ($featured_image): ?>
        <p>Current Image:</p>
        <img src="../../uploads/blog_images/<?= htmlspecialchars($featured_image) ?>" alt="Featured Image" style="max-width:200px;">
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Update Post</button>
    <a href="manage.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
