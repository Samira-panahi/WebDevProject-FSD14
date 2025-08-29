<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/controller/RsvpController.php';

$controller = new RsvpController();

$page = $_GET['page'] ?? null;
$eventId = $_POST['event_id'] ?? $_GET['event_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: " . BASE_URL . "/public/login.php");
    exit;
}

switch ($page) {
    case 'join':
        if ($eventId) {
            $message = $controller->join($userId, $eventId);
        }
        header("Location: " . BASE_URL . "/public/event.php?page=show&id=$eventId&msg=" . urlencode($message));
        exit;

    case 'cancel':
        if ($eventId) {
            $message = $controller->cancel($userId, $eventId);
        }
        header("Location: " . BASE_URL . "/public/event.php?page=show&id=$eventId&msg=" . urlencode($message));
        exit;

    default:
        echo "Invalid RSVP action.";
}
