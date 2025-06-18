<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit;
}

$id = (int)$_GET['id'];

// Optionally delete the photo file from server
$stmt = $pdo->prepare("SELECT photo_path FROM testimonials WHERE id = ?");
$stmt->execute([$id]);
$testimonial = $stmt->fetch();

if ($testimonial && !empty($testimonial['photo_path'])) {
    $filePath = __DIR__ . "/../../uploads/testimonials/" . $testimonial['photo_path'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Delete testimonial record
$stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage.php");
exit;
