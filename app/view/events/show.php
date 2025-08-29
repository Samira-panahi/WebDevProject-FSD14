<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Event FEATURE (Belinda's part) -->
<h1><?= htmlspecialchars($event['title']) ?></h1>
<p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
<p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?></p>
<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
<img src="<?= BASE_URL ?>/public/uploads/events/<?= htmlspecialchars($event['image']) ?>" width="300" class="img-thumbnail">

<hr>

<a href="<?= BASE_URL ?>/app/view/rsvp/join.php" class="btn btn-warning">Join</a>
<a href="event.php?page=list" class="btn btn-secondary">Back to List</a>
<hr>

<?php
// RSVP FEATURE (Samira's part)
$eventId = $event['id'] ?? null;

if ($eventId && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if user already RSVP’d
    $check = $pdo->prepare("SELECT * FROM rsvps WHERE user_id = ? AND event_id = ?");
    $check->execute([$userId, $eventId]);
    $alreadyJoined = $check->fetch();

    if ($alreadyJoined) {
        // Show cancel button
        echo '<form action="/rsvp/cancel.php" method="POST">
                <input type="hidden" name="event_id" value="' . $eventId . '">
                <button type="submit" class="btn btn-danger mt-2">Cancel RSVP</button>
              </form>';
    } else {
        // Show join button
        echo '<form action="/rsvp/join.php" method="POST">
                <input type="hidden" name="event_id" value="' . $eventId . '">
                <button type="submit" class="btn btn-success mt-2">Join Event</button>
              </form>';
    }
}

// Show participants
echo "<h3 class='mt-4'>Participants:</h3>";

if ($eventId) {
    $stmt = $pdo->prepare("
        SELECT u.name, u.profile_image 
        FROM rsvps r 
        INNER JOIN users u ON r.user_id = u.id 
        WHERE r.event_id = ?
    ");
    $stmt->execute([$eventId]);
    $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($participants) {
        foreach ($participants as $p) {
            $image = $p['profile_image'] 
                ? "/uploads/profiles/" . $p['profile_image'] 
                : "/uploads/profiles/default.png";

            echo '<div style="margin-bottom:10px;">
                    <img src="' . $image . '" width="40" height="40" style="border-radius:50%; margin-right:8px;">
                    ' . htmlspecialchars($p['name']) . '
                  </div>';
        }
    } else {
        echo "<p>No participants yet.</p>";
    }
}
?>

<?php include __DIR__ . '/../layout/footer.php'; ?>

