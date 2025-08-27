<?php

require_once __DIR__ . '/../../config/config.php';

class RsvpController {

    // Join RSVP
    public function join($userId, $eventId) {
        global $pdo;

        // Check if already joined
        $stmt = $pdo->prepare("SELECT id FROM rsvps WHERE user_id = ? AND event_id = ?");
        $stmt->execute([$userId, $eventId]);
        if ($stmt->fetch()) {
            return "You already joined this event.";
        }

        // Insert RSVP
        $stmt = $pdo->prepare("INSERT INTO rsvps (user_id, event_id) VALUES (?, ?)");
        if ($stmt->execute([$userId, $eventId])) {
            return "RSVP successful!";
        }
        return "Error joining event.";
    }

    // Cancel RSVP
    public function cancel($userId, $eventId) {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM rsvps WHERE user_id = ? AND event_id = ?");
        if ($stmt->execute([$userId, $eventId])) {
            return "RSVP cancelled.";
        }
        return "Error cancelling RSVP.";
    }

    // Get all participants of an event
    public function getParticipants($eventId) {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT users.id, users.name, users.profile_image 
            FROM rsvps
            INNER JOIN users ON rsvps.user_id = users.id
            WHERE rsvps.event_id = ?
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetchAll();
    }
}
