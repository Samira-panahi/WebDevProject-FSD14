<?php
require_once __DIR__ . '/../../config/config.php';

class Event {
    private $pdo;

    // Accept PDO connection from config.php
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY event_date ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO events (title, description, event_date, capacity, image)
             VALUES (:title, :description, :event_date, :capacity, :image)"
        );
        $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[':id'] = $id;
        $stmt = $this->pdo->prepare(
            "UPDATE events 
             SET title=:title, description=:description, event_date=:event_date, 
                 capacity=:capacity, image=:image
             WHERE id=:id"
        );
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id=:id");
        $stmt->execute([':id' => $id]);
    }
}

