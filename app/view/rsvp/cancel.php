<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/WebDevProject-FSD14/app/controller/RsvpController.php';

$userId = $_SESSION['user_id'] ?? null;
$eventId = $_POST['event_id'] ?? null;

if (!$userId || !$eventId) {
    die("Invalid request.");
}

$rsvpController = new RsvpController();
$message = $rsvpController->cancel($userId, $eventId);

// Redirect back to the event page with a message
header("Location: ../../public/event.php?page=show&id=$eventId&msg=" . urlencode($message));
exit;
