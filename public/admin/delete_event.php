<?php
session_start();
require_once __DIR__ . '/../../config/config.php';

// Only admin can delete
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$event_id = $_POST['event_id'] ?? null;
if (!$event_id) {
    die("Invalid Event ID");
}

// Delete event
$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$event_id]);

// Redirect back to admin events page
header("Location: admin_event.php?msg=Event deleted successfully");
exit;
