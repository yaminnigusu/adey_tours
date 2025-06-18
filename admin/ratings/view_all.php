<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

// Fetch all ratings from DB
$stmt = $pdo->query("SELECT * FROM ratings ORDER BY created_at DESC");
$ratings = $stmt->fetchAll();

// Function to render star icons
function renderStars($count) {
    $fullStar = '<span class="text-warning">&#9733;</span>';  // ★
    $emptyStar = '<span class="text-secondary">&#9734;</span>'; // ☆
    return str_repeat($fullStar, $count) . str_repeat($emptyStar, 5 - $count);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Ratings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include("../partials/navbar.php"); ?>

<div class="container mt-4">
    <h1 class="mb-4">All Customer Ratings</h1>

    <?php if (count($ratings) > 0): ?>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ratings as $r): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['customer_name'] ?? 'Anonymous') ?></td>
                        <td><?= renderStars((int)$r['rating']) ?></td>
                        <td><?= nl2br(htmlspecialchars($r['comment'] ?? '')) ?></td>
                        <td><?= $r['created_at'] ?></td>
                        <td>
                            <a href="delete.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this rating?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No ratings have been submitted yet.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
