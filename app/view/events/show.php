<?php include __DIR__.'/../layout/header.php'; ?>

<h1><?= htmlspecialchars($event['title']) ?></h1>
<p><strong>Date:</strong> <?= $event['event_date'] ?></p>
<p><strong>Capacity:</strong> <?= $event['capacity'] ?></p>
<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
<p>
    <img src="<?= BASE_URL ?>/uploads/events/<?= $event['image'] ?>" width="300" class="img-thumbnail">
</p>

<a href="<?= BASE_URL ?>/index.php?page=edit&id=<?= $event['id'] ?>" class="btn btn-warning">Edit</a>
<a href="<?= BASE_URL ?>/index.php?page=delete&id=<?= $event['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
<a href="<?= BASE_URL ?>/index.php?page=list" class="btn btn-secondary">Back to List</a>

<?php include __DIR__.'/../layout/footer.php'; ?>

