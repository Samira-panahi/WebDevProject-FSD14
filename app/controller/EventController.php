<?php
require_once __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../../config/config.php';

class EventController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        $this->model = new Event($pdo);
        $this->pdo = $pdo;
    }

<<<<<<< HEAD
    public function index()
    {
        $events = $this->model->getAll();
        include __DIR__ . '/../view/events/list.php';
    }

    public function show($id)
    {
=======
    // Show all events
    public function index() {
        $events = $this->model->getAll(); // fetch all events
        include __DIR__ . '/../view/events/list.php';
    }

    // Show a single event
    public function show($id) {
>>>>>>> samira
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
<<<<<<< HEAD

    public function create()
    {
        $errors = [];
        $event = ['title' => '', 'description' => '', 'event_date' => '', 'capacity' => '', 'image' => 'default_event.png'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = Validation::validateEvent($_POST, $_FILES['image'] ?? null);

            if (empty($result['errors'])) {
                $data = [
                    ':user_id'    => $_SESSION['user_id'],
                    ':title'      => $_POST['title'],
                    ':description' => $_POST['description'],
                    ':event_date' => $_POST['event_date'],
                    ':capacity'   => (int)$_POST['capacity'],
                    ':image'      => $result['image']
                ];
                $this->model->create($data);
                header("Location: " . BASE_URL . "/public/event.php?page=list");
                exit;
            }

            $errors = $result['errors'];
            $event = array_merge($event, $_POST);
            if (!empty($_FILES['image']['name'])) {
                $event['image'] = $_FILES['image']['name'];
            }
        }

        include __DIR__ . '/../view/events/create.php';
    }

    public function edit($id)
    {
        if (!$id) die("Event ID required");
        $event = $this->model->getById($id);
        if (!$event) die("Event not found");

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = Validation::validateEvent($_POST, $_FILES['image'] ?? null);

            if (empty($result['errors'])) {
                $image = $result['image'] === 'default_event.png' && !empty($event['image'])
                    ? $event['image']
                    : $result['image'];

                $data = [
                    ':title' => $_POST['title'],
                    ':description' => $_POST['description'],
                    ':event_date' => $_POST['event_date'],
                    ':capacity' => (int)$_POST['capacity'],
                    ':image' => $image
                ];

                $this->model->update($id, $data);
                header("Location: " . BASE_URL . "/public/event.php?page=show&id=$id");
                exit;
            }

            $errors = $result['errors'];
        }

        include __DIR__ . '/../view/events/edit.php';
    }

    public function delete($id)
    {
        if (!$id) die("Event ID required");
        $this->model->delete($id);
        header("Location: " . BASE_URL . "/public/event.php?page=list");
        exit;
    }

    public function myEvents()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $events = $this->model->getByUser($_SESSION['user_id']);
        include __DIR__ . '/../view/events/my_events.php';
    }
=======
>>>>>>> samira
}
