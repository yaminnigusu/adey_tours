<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

$photo_id = $_GET['id'] ?? null;
$gallery_id = $_GET['gallery_id'] ?? null;

if ($photo_id && $gallery_id) {
    // Get photo path to delete the file
    $stmt = $conn->prepare("SELECT photo_path FROM gallery_photos WHERE id = ?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $photo = $result->fetch_assoc();

    if ($photo) {
        $file_path = "../../" . $photo['photo_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        // Delete record from DB
        $stmt = $conn->prepare("DELETE FROM gallery_photos WHERE id = ?");
        $stmt->bind_param("i", $photo_id);
        $stmt->execute();
    }
}

header("Location: view_photos.php?gallery_id=" . $gallery_id);
exit;
