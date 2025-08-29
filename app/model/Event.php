<?php
require_once __DIR__ . '/../../config/config.php';

class Event
{
    private $pdo;

    // Accept PDO connection from config.php
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY event_date ASC");
        return $stmt->fetchAll();
    }

    //  Get single event with user info
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // public function getAll()
    // {
    //     $stmt = $this->pdo->query("
    //     SELECT e.*, u.name AS user_name, u.email AS user_email
    //     FROM events e
    //     JOIN users u ON e.user_id = u.id
    //     ORDER BY e.event_date ASC
    // ");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function getById($id)
    // {
    //     $stmt = $this->pdo->prepare("
    //     SELECT e.*, u.name AS user_name, u.email AS user_email
    //     FROM events e
    //     JOIN users u ON e.user_id = u.id
    //     WHERE e.id = :id
    // ");
    //     $stmt->execute([':id' => $id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }


    //  Create event (requires user_id from session)
    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO events (user_id, title, description, event_date, capacity, image)
         VALUES (:user_id, :title, :description, :event_date, :capacity, :image)"
        );
        $stmt->execute($data);
    }

    //  Update event
    public function update($id, $data)
    {
        $data[':id'] = $id;
        $stmt = $this->pdo->prepare(
            "UPDATE events 
             SET title=:title, description=:description, event_date=:event_date, 
                 capacity=:capacity, image=:image
             WHERE id=:id"
        );
        $stmt->execute($data);
    }

    //  Delete event
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id=:id");
        $stmt->execute([':id' => $id]);
    }

    //  NEW: Find all events created by a specific user
    public function getByUser($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT e.*, u.first_name AS user_name, u.email AS user_email
            FROM events e
            JOIN users u ON e.user_id = u.id
            WHERE e.user_id = :user_id
            ORDER BY e.event_date ASC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
