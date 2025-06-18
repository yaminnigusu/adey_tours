<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

// Fetch all testimonials ordered by newest first
$stmt = $pdo->query("SELECT * FROM testimonials ORDER BY submitted_at DESC");
$testimonials = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Testimonials</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .photo-thumb {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 5px;
    }
  </style>
</head>
<body>
<?php include("../partials/navbar.php"); ?>

<div class="container mt-4">
  <h1>Testimonials</h1>

  <?php if (count($testimonials) > 0): ?>
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Customer Name</th>
          <th>Message</th>
          <th>Photo</th>
          <th>Approved</th>
          <th>Submitted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($testimonials as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t['id']) ?></td>
            <td><?= htmlspecialchars($t['customer_name']) ?></td>
            <td><?= nl2br(htmlspecialchars($t['message'])) ?></td>
            <td>
              <?php if (!empty($t['photo_path'])): ?>
                <img src="../../uploads/testimonials/<?= htmlspecialchars($t['photo_path']) ?>" alt="Photo" class="photo-thumb" />
              <?php else: ?>
                <span class="text-muted">No Photo</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($t['approved']): ?>
                <span class="badge bg-success">Yes</span>
              <?php else: ?>
                <span class="badge bg-secondary">No</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($t['submitted_at']) ?></td>
            <td>
              <?php if ($t['approved']): ?>
                <a href="approve.php?id=<?= $t['id'] ?>&action=unapprove" class="btn btn-sm btn-warning">Unapprove</a>
              <?php else: ?>
                <a href="approve.php?id=<?= $t['id'] ?>&action=approve" class="btn btn-sm btn-success">Approve</a>
              <?php endif; ?>
              <a href="delete.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No testimonials found.</p>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
