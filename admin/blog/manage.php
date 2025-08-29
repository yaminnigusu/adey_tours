<?php
session_start();
include("../../includes/auth_check.php"); // Auth check
include("../../config/database.php");

// Fetch all blog posts ordered by newest first
$stmt = $pdo->query("SELECT id, title, slug, category, created_at FROM blog_posts ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Blog Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { min-height: 100vh; background-color: #f8f9fa; }
    .content-area { padding: 20px; }
    .table th, .table td { vertical-align: middle; }
    .sidebar { min-height: 100vh; background: linear-gradient(180deg, #343a40 0%, #495057 100%); }
    .sidebar .nav-link { color: #ffc107; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.25rem; transition: all 0.2s; }
    .sidebar .nav-link:hover { background-color: #ffc107; color: #343a40; }
    .sidebar .nav-link.active { background-color: #ff9800; color: #fff; }
    .sidebar h5 { color: #ff9800; font-weight: bold; padding: 1rem; }
  </style>
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    
      <?php include("../partials/sidebar.php"); ?>
    

   <!-- Content Area -->
    <div class="col-md-9 col-lg-10 content-area">
      <h1 class="mb-4">Blog Posts</h1>
      <a href="add_post.php" class="btn btn-success mb-3"><i class="bi bi-plus-lg"></i> Add New Post</a>

      <?php if(count($blogs) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Slug</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($blogs as $blog): ?>
              <tr>
                <td><?= htmlspecialchars($blog['title']) ?></td>
                <td><?= htmlspecialchars($blog['category'] ?? '') ?></td>
                <td><?= htmlspecialchars($blog['slug'] ?? '') ?></td>
                <td><?= date('Y-m-d H:i', strtotime($blog['created_at'])) ?></td>
                <td>
                  <a href="edit_post.php?id=<?= $blog['id'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-fill"></i> Edit</a>
                  <a href="delete_post.php?id=<?= $blog['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');"><i class="bi bi-trash-fill"></i> Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <p>No blog posts found.</p>
      <?php endif; ?>
    </div>

  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
