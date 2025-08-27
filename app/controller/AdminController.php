<?php
// Admin (Samira's part)

require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/config.php';

class AdminController {

    // Dashboard stats: total users, events, RSVPs
    public function dashboard() {
        global $pdo;

        $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalEvents = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
        $totalRsvps = $pdo->query("SELECT COUNT(*) FROM rsvps")->fetchColumn();

        return [
            'users' => $totalUsers,
            'events' => $totalEvents,
            'rsvps' => $totalRsvps
        ];
    }

    // List all events for admin with approve/delete buttons
    public function events() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC");
        return $stmt->fetchAll();
    }

    // List all users
    public function users() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // List RSVPs per event with user info
    public function rsvps() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT r.id AS rsvp_id, e.title AS event_title, u.name AS user_name, u.profile_image, r.created_at
            FROM rsvps r
            INNER JOIN users u ON r.user_id = u.id
            INNER JOIN events e ON r.event_id = e.id
            ORDER BY r.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    // Approve/Delete events (example POST handler)
    public function deleteEvent($eventId) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        return $stmt->execute([$eventId]);
    }
}
