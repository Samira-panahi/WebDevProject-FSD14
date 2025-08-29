<?php

require_once __DIR__ . '/../../../config/config.php';

// Middleware: ensure admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /auth/login.php");
    exit;
}

$eventId = $_GET['event_id'] ?? null;
if (!$eventId) die("Event ID missing.");

// Fetch event
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$event) die("Event not found.");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['event_date'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];

    $update = $pdo->prepare("UPDATE events SET title = ?, event_date = ?, capacity = ?, description = ? WHERE id = ?");
    $update->execute([$title, $date, $capacity, $description, $eventId]);

    header("Location: events.php?msg=Event+updated+successfully");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Event</h1>

    <form method="POST">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="event_date" class="form-control" value="<?= $event['event_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" class="form-control" value="<?= $event['capacity'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Event</button>
        <a href="events.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
