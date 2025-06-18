<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title) {
        $stmt = $pdo->prepare("INSERT INTO galleries (title, description) VALUES (?, ?)");
        if ($stmt->execute([$title, $description])) {
            header("Location: manage.php");
            exit;
        } else {
            $error = "Failed to create album. Please try again.";
        }
    } else {
        $error = "Title is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include("../partials/navbar.php"); ?>
<div class="container mt-4">
    <h1>Add New Album</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Album Title</label>
            <input type="text" name="title" id="title" class="form-control" required maxlength="100" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" />
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Album Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Album</button>
        <a href="manage.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
