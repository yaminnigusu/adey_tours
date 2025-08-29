<?php
session_start();

$page_title = 'Manage Attractions';

include('../../config/database.php'); // DB connection

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM attractions WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: manage.php");
    exit();
}

// Fetch all attractions
$stmt = $pdo->query("SELECT * FROM attractions ORDER BY id DESC");
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $page_title ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }
    .sidebar {
        min-height: 100vh;
        background-color: #343a40;
        color: #fff;
        padding-top: 1rem;
    }
    .sidebar a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 0.5rem 1rem;
        margin-bottom: 0.25rem;
        border-radius: 5px;
    }
    
    .table img {
        border-radius: 5px;
    }
    .top-navbar {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
       <?php include("../partials/sidebar.php"); ?>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <nav class="navbar top-navbar sticky-top mb-3">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Manage Attractions</span>
                </div>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Attractions</h2>
                <a href="add.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Attraction</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($attractions as $attr): ?>
                        <tr>
                            <td><?= $attr['id'] ?></td>
                            <td><?= htmlspecialchars($attr['title']) ?></td>
                            <td>
                                <?php if($attr['image']): ?>
                                <img src="../../uploads/attractions/<?= htmlspecialchars($attr['image']) ?>" width="80" alt="<?= htmlspecialchars($attr['title']) ?>">
                                <?php else: ?>
                                No Image
                                <?php endif; ?>
                            </td>
                            <td><?= substr(strip_tags($attr['description']), 0, 100) ?>...</td>
                            <td>
                                <a href="edit.php?id=<?= $attr['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                                <a href="manage.php?delete_id=<?= $attr['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this attraction?')"><i class="bi bi-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
