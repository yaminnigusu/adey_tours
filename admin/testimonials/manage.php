<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

// Fetch all testimonials ordered by newest first
$stmt = $pdo->query("SELECT * FROM testimonials ORDER BY submitted_at DESC");
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Testimonials</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { min-height: 100vh; background-color: #f8f9fa; }
    .content-area { padding: 20px; }
    .table th, .table td { vertical-align: middle; }
    .photo-thumb { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
    .sidebar { min-height: 100vh; background: linear-gradient(180deg, #343a40 0%, #495057 100%); }
    .sidebar .nav-link { color: #ffc107; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.25rem; transition: all 0.2s; }
    .sidebar .nav-link:hover { background-color: #ffc107; color: #343a40; }
    
    .sidebar h5 { color: #ff9800; font-weight: bold; padding: 1rem; }
  </style>
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar for desktop -->
   
      <?php include("../partials/sidebar.php"); ?>
    

    <!-- Content Area -->
    <div class="col-md-9 col-lg-10 content-area">
      <h1 class="mb-4">Testimonials</h1>

      <?php if(count($testimonials) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-dark">
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
            <?php foreach($testimonials as $t): ?>
              <tr>
                <td><?= htmlspecialchars($t['id']) ?></td>
                <td><?= htmlspecialchars($t['customer_name']) ?></td>
                <td><?= nl2br(htmlspecialchars($t['message'])) ?></td>
                <td>
                  <?php if(!empty($t['photo_path'])): ?>
                    <img src="../../uploads/testimonials/<?= htmlspecialchars($t['photo_path']) ?>" alt="Photo" class="photo-thumb">
                  <?php else: ?>
                    <span class="text-muted">No Photo</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if($t['approved']): ?>
                    <span class="badge bg-success">Yes</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">No</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($t['submitted_at']) ?></td>
                <td>
                  <?php if($t['approved']): ?>
                    <a href="approve.php?id=<?= $t['id'] ?>&action=unapprove" class="btn btn-sm btn-warning"><i class="bi bi-x-circle-fill"></i> Unapprove</a>
                  <?php else: ?>
                    <a href="approve.php?id=<?= $t['id'] ?>&action=approve" class="btn btn-sm btn-success"><i class="bi bi-check-circle-fill"></i> Approve</a>
                  <?php endif; ?>
                  <a href="delete.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?');"><i class="bi bi-trash-fill"></i> Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <p>No testimonials found.</p>
      <?php endif; ?>
    </div>

  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
