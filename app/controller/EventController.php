<?php

require_once __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../helpers/Validation.php';

class EventController {
    private $model;

    public function __construct($pdo) {
        $this->model = new Event($pdo);
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
        $result = Validation::validateEvent($post, $files['image'] ?? null);
        
        if (!empty($result['errors'])) {
            return $result['errors'];
        }

        $data = [
            ':title' => $post['title'],
            ':description' => $post['description'],
            ':event_date' => $post['event_date'],
            ':capacity' => (int)$post['capacity'],
            ':image' => $result['image']
        ];

        $this->model->create($data);
        return [];
    }


        public function edit($id, $post, $files) {
        $event = $this->model->getById($id);
        if (!$event) die("Event not found");

        // Validate event data and handle image
        $result = Validation::validateEvent($post, $files['image'] ?? null);

        if (!empty($result['errors'])) {
            return $result['errors']; // flat array
        }

        // Use uploaded image or keep existing
        $image = $result['image'] === 'default_event.png' && !empty($event['image']) 
                    ? $event['image'] 
                    : $result['image'];

        $data = [
            ':title' => $post['title'],
            ':description' => $post['description'],
            ':event_date' => $post['event_date'],
            ':capacity' => (int)$post['capacity'],
            ':image' => $image
        ];

        $this->model->update($id, $data);

        return []; 
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
