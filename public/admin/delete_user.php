<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/config.php';
session_start();

// Only admin can delete
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die("Access denied.");
}

// POST request with user_id
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    if (!$user_id) die("Invalid request.");

    // Delete user
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    // Redirect back to admin users page
    header("Location: admin_users.php?msg=User+deleted+successfully");
    exit;
} else {
    die("Invalid request method.");
}
