<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Event FEATURE (Belinda's part) -->
<h1><?= htmlspecialchars($event['title']) ?></h1>
<p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
<p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?></p>
<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
<img src="<?= BASE_URL ?>/public/uploads/events/<?= htmlspecialchars($event['image']) ?>" width="300" class="img-thumbnail">

<<<<<<< HEAD
<<<<<<< HEAD
<a href="<?= BASE_URL ?>/app/view/rsvp/join.php" class="btn btn-warning">Join</a>

<a href="event.php?page=list" class="btn btn-secondary">Back to List</a>
 
=======
>>>>>>> c8957bc8ef68e8b6c42a88f463a9f7a662319f25
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
<<<<<<< HEAD
 
<?php include __DIR__ . '/../layout/footer.php'; ?>
=======
<hr>

<!-- Edit/Delete buttons for creator -->
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_id']): ?>
    <a href="event.php?page=edit&id=<?= $event['id'] ?>" class="btn btn-warning">Edit</a>
    <a href="event.php?page=delete&id=<?= $event['id'] ?>" class="btn btn-danger"
       onclick="return confirm('Are you sure?')">Delete</a>
<?php endif; ?>

<a href="event.php?page=list" class="btn btn-secondary">Back to List</a>

<hr>

<!-- RSVP -->
<?php if (isset($_SESSION['user_id'])): ?>
    <?php if ($alreadyJoined): ?>
        <form method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <button type="submit" name="cancel" class="btn btn-danger mt-2">Cancel RSVP</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <button type="submit" name="join" class="btn btn-success mt-2">Join Event</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <a href="<?= BASE_URL ?>/public/login.php" class="btn btn-primary mt-2">Login to Join</a>
<?php endif; ?>

<hr>

<h3>Participants:</h3>
<?php if ($participants): ?>
    <?php foreach ($participants as $p): 
        $image = $p['profile_image'] 
            ? BASE_URL."/public/uploads/profiles/".$p['profile_image'] 
            : BASE_URL."/public/uploads/profiles/default.png"; 
    ?>
        <div style="margin-bottom:10px;">
            <img src="<?= $image ?>" width="40" height="40" style="border-radius:50%; margin-right:8px;">
            <?= htmlspecialchars($p['full_name']) ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No participants yet.</p>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> samira
=======

<?php include __DIR__ . '/../layout/footer.php'; ?>

>>>>>>> c8957bc8ef68e8b6c42a88f463a9f7a662319f25
