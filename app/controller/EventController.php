<?php
require_once __DIR__ . '/../model/Event.php';

class EventController {
    private $model;

    public function __construct() {
        $this->model = new Event();
    }

    public function index() {
        $events = $this->model->getAll();
        return ['events' => $events];
    }

    public function show($id) {
        $event = $this->model->getById($id);
        if (!$event) die("Event not found");
        return ['event' => $event];
    }

    public function create($post, $files) {
        $image = $this->handleImage($files['image'] ?? null);
        $data = [
            ':title' => $post['title'],
            ':description' => $post['description'],
            ':event_date' => $post['event_date'],
            ':capacity' => (int)$post['capacity'],
            ':image' => $image
        ];
        $this->model->create($data);
        return true;
    }

    public function edit($id, $post, $files) {
        $event = $this->model->getById($id);
        if (!$event) die("Event not found");

        $image = $event['image'];
        if (!empty($files['image']['name'])) {
            $image = $this->handleImage($files['image']);
        }

        $data = [
            ':title' => $post['title'],
            ':description' => $post['description'],
            ':event_date' => $post['event_date'],
            ':capacity' => (int)$post['capacity'],
            ':image' => $image
        ];

        $this->model->update($id, $data);
        return true;
    }

    public function delete($id) {
        $this->model->delete($id);
        return true;
    }

    private function handleImage($file) {
        $imageName = 'default_event.png';
        if ($file && !empty($file['name'])) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $imageName = time() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], __DIR__ . '/../view/events/upload/' . $imageName);
        }
        return $imageName;
    }
}
?>
