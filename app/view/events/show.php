<?php 
if(session_status() == PHP_SESSION_NONE) session_start();
include __DIR__ . '/../layout/header.php'; 
?>

<h1><?= htmlspecialchars($event['title']) ?></h1>
<p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
<p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?></p>
<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
<img src="<?= BASE_URL ?>/public/uploads/events/<?= htmlspecialchars($event['image']) ?>" width="300" class="img-thumbnail">

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
