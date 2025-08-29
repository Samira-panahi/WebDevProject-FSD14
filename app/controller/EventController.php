<?php
require_once __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../helpers/Validation.php';

class EventController {
    private $model;
    private $pdo;

    public function __construct($pdo) {
        $this->model = new Event($pdo);
        $this->pdo = $pdo;
    }

    // Show all events
    public function index() {
        $events = $this->model->getAll(); // fetch all events
        include __DIR__ . '/../view/events/list.php';
    }

    // Show a single event
    public function show($id) {
        if (!$id) die("Event ID required");

        $event = $this->model->getById($id);
        if (!$event) die("Event not found");

        $alreadyJoined = false;
        $participants = [];

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Handle join/cancel directly
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['join'])) {
                    $stmt = $this->pdo->prepare("INSERT IGNORE INTO rsvps (user_id, event_id) VALUES (?, ?)");
                    $stmt->execute([$userId, $id]);
                } elseif (isset($_POST['cancel'])) {
                    $stmt = $this->pdo->prepare("DELETE FROM rsvps WHERE user_id = ? AND event_id = ?");
                    $stmt->execute([$userId, $id]);
                }
                header("Location: ".$_SERVER['REQUEST_URI']);
                exit;
            }

            // Check if already joined
            $stmt = $this->pdo->prepare("SELECT * FROM rsvps WHERE user_id = ? AND event_id = ?");
            $stmt->execute([$userId, $id]);
            $alreadyJoined = $stmt->fetch() ? true : false;
        }

        // Get participants
        $stmt = $this->pdo->prepare("
            SELECT CONCAT(u.first_name, ' ', u.last_name) AS full_name, u.profile_picture AS profile_image
            FROM rsvps r
            INNER JOIN users u ON r.user_id = u.id
            WHERE r.event_id = ?
        ");
        $stmt->execute([$id]);
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../view/events/show.php';
    }
}
