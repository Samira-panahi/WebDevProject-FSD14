<?php

require_once __DIR__ . '/../../config/config.php';
session_start();

// ===============================
// ADMIN DELETE EVENT (Samira's part)
// ===============================

// Middleware: check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Check POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'] ?? null;

    if (!$eventId) {
        die("Invalid request.");
    }

    // Delete the event safely
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    if ($stmt->execute([$eventId])) {
        // Redirect back to admin events page with success message
        header("Location: events.php?msg=Event+deleted+successfully");
        exit;
    } else {
        die("Error deleting event.");
    }
} else {
    die("Invalid request method.");
}
