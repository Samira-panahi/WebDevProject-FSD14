<?php

require_once __DIR__ . '/../../Controllers/RsvpController.php';
//require_once __DIR__ . '/../../Helpers/Session.php';

session_start();

$userId = $_SESSION['user_id'] ?? null;
$eventId = $_GET['event_id'] ?? null;

if (!$userId || !$eventId) {
    die("Invalid request.");
}

$rsvpController = new RsvpController();
$message = $rsvpController->cancel($userId, $eventId);

echo $message;
echo "<br><a href='../events/show.php?id=$eventId'>Back to event</a>";
