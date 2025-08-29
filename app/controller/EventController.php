<?php
require_once __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../../config/config.php';

class EventController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Event($pdo);
    }

    public function index()
    {
        $events = $this->model->getAll();
        include __DIR__ . '/../view/events/list.php';
    }

    public function show($id)
    {
        if (!$id) die("Event ID required");
        $event = $this->model->getById($id);
        if (!$event) die("Event not found");
        include __DIR__ . '/../view/events/show.php';
    }

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
}
