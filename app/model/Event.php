<?php
require_once __DIR__ . '/../../config/config.php';

class Event {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
            DB_USER,
            DB_PASS
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY event_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
            "UPDATE events SET title=:title, description=:description, 
             event_date=:event_date, capacity=:capacity, image=:image
             WHERE id=:id"
        );
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id=:id");
        $stmt->execute([':id' => $id]);
    }
}
?>
