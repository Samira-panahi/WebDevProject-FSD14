<?php
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/controller/AdminController.php';

// Middleware: ensure admin logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$event_id = $_GET['event_id'] ?? null;
if (!$event_id) {
    die("Invalid event ID.");
}

// Fetch event info
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$event) {
    die("Event not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $date = $_POST['event_date'] ?? '';
    $capacity = $_POST['capacity'] ?? '';

    $updateStmt = $pdo->prepare("UPDATE events SET title = ?, event_date = ?, capacity = ? WHERE id = ?");
    $updateStmt->execute([$title, $date, $capacity, $event_id]);

    header("Location: admin_events.php?msg=Event updated successfully");
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
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" required>
        </div>
        <div class="mb-3">
        <label class="form-label">Date & Time</label>
        <input type="datetime-local" name="event_date" class="form-control" 
        value="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" value="<?= $event['capacity'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="../events.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
