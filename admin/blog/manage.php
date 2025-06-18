<?php
session_start();
include("../../includes/auth_check.php"); // Your auth check
include("../../config/database.php");

// Fetch all blog posts ordered by newest first
$stmt = $pdo->query("SELECT id, title, slug, category, created_at FROM blog_posts ORDER BY created_at DESC");
$blogs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Blog Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container mt-4">
  <h1>Blog Posts</h1>
  <a href="add_post.php" class="btn btn-success mb-3">Add New Post</a>

  <?php if (count($blogs) > 0): ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Slug</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($blogs as $blog): ?>
          <tr>
            <td><?= htmlspecialchars($blog['title']) ?></td>
            <td><?= htmlspecialchars($blog['category'] ?? '') ?></td>
            <td><?= htmlspecialchars($blog['slug'] ?? '') ?></td>
            <td><?= date('Y-m-d H:i', strtotime($blog['created_at'])) ?></td>
            <td>
              <a href="edit_post.php?id=<?= $blog['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="delete_post.php?id=<?= $blog['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?');">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No blog posts found.</p>
  <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
