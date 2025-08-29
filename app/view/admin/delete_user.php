<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../helpers/Session.php';

Session::start();

if (!Session::has('user_role') || Session::get('user_role') !== 'admin') {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    if (!$user_id) die("Invalid request.");

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$user_id])) {
        header("Location: admin_users.php?msg=User+deleted+successfully");
        exit;
    } else {
        die("Error deleting user.");
    }
} else {
    die("Invalid request.");
}
