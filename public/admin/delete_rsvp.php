<?php
// ===============================
// DELETE / CANCEL RSVP (Admin)
// ===============================

require_once __DIR__ . '/../../config/config.php';
session_start();

// Only admin can delete RSVPs
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /public/login.php");
    exit;
}

// Check for POST request and RSVP ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rsvp_id'])) {
    $rsvp_id = intval($_POST['rsvp_id']);

    // Delete RSVP from database
    $stmt = $pdo->prepare("DELETE FROM rsvps WHERE id = ?");
    $stmt->execute([$rsvp_id]);

    // Redirect back to the RSVPs page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    // Invalid access
    header("Location: /public/admin/rsvps.php");
    exit;
}
