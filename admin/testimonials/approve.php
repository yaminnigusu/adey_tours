<?php
session_start();
include("../../includes/auth_check.php");
include("../../config/database.php");

if (!isset($_GET['id'], $_GET['action']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit;
}

$id = (int)$_GET['id'];
$action = $_GET['action'];

if ($action === 'approve') {
    $approved = 1;
} elseif ($action === 'unapprove') {
    $approved = 0;
} else {
    header("Location: manage.php");
    exit;
}

$stmt = $pdo->prepare("UPDATE testimonials SET approved = ? WHERE id = ?");
$stmt->execute([$approved, $id]);

header("Location: manage.php");
exit;
