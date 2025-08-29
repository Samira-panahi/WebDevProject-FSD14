<?php
include __DIR__ . '/../layout/header.php'; ?>

<!-- event FEATURE (Belinda's part) -->

<h1><?= htmlspecialchars($event['title']) ?></h1>
<p><strong>Date:</strong> <?= $event['event_date'] ?></p>
<p><strong>Capacity:</strong> <?= $event['capacity'] ?></p>
<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
<p>
    <img src="<?= BASE_URL ?>/public/uploads/events/<?= $event['image'] ?>" width="300" class="img-thumbnail">
</p>

<a href="event.php?page=list" class="btn btn-secondary">Back to List</a>

<hr>


<!-- RSVP FEATURE (Samira's part) -->

<?php if (isset($_SESSION['user_id'])): ?>
    <?php if ($alreadyJoined): ?>
        <form action="event.php?page=rsvp_cancel" method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <button type="submit" class="btn btn-danger mt-2">Cancel RSVP</button>
        </form>
    <?php else: ?>
        <form action="event.php?page=rsvp_join" method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <button type="submit" class="btn btn-success mt-2">Join Event</button>
        </form>

    <?php endif; ?>
<?php endif; ?>

<h3 class="mt-4">Participants:</h3>

<?php if (!empty($participants)): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Profile</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $p): ?>
                <?php 
                $image = !empty($p['profile_picture']) 
                    ? BASE_URL . "/uploads/profiles/" . $p['profile_picture'] 
                    : BASE_URL . "/uploads/profiles/default.png"; 
                ?>
                <tr>
                    <td>
                        <img src="<?= $image ?>" width="40" height="40" style="border-radius:50%;">
                    </td>
                    <td>
                        <?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No participants yet.</p>
<?php endif; ?>




<?php include __DIR__ . '/../layout/footer.php'; ?>