<?php include __DIR__ . '/../layout/header.php'; ?>

<h1 class="mb-4">My Events</h1>

<div class="row">
    <?php if (!empty($events)): ?>
        <?php foreach($events as $e): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= BASE_URL ?>/public/uploads/events/<?= htmlspecialchars($e['image']) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($e['title']) ?>" 
                         style="height:200px; object-fit:cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($e['title']) ?></h5>
                        <p class="card-text mb-1"><strong>Date:</strong> <?= htmlspecialchars($e['event_date']) ?></p>
                        <p class="card-text mb-3"><strong>Capacity:</strong> <?= htmlspecialchars($e['capacity']) ?></p>

                        <div class="mt-auto">
                            <a href="event.php?page=show&id=<?= $e['id'] ?>" 
                               class="btn btn-info btn-sm">View</a>
                            <a href="event.php?page=edit&id=<?= $e['id'] ?>" 
                               class="btn btn-warning btn-sm">Edit</a>
                            <a href="event.php?page=delete&id=<?= $e['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You haven't created any events yet.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
