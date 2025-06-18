<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch post to get image filename for deletion
$stmt = $pdo->prepare("SELECT featured_image FROM blog_posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if ($post) {
    // Delete image file if exists
    if ($post['featured_image']) {
        $image_path = __DIR__ . '/../../uploads/blog_images/' . $post['featured_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete the post record
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: manage.php");
exit;
