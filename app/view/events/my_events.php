<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-3">My Events</h1>

    <?php if (!empty($events)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Capacity</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars($event['event_date']) ?></td>
                        <td><?= htmlspecialchars($event['capacity']) ?></td>
                        <td><?= htmlspecialchars($event['created_at']) ?></td>
                        <td>
                            <a href="event.php?page=show&id=<?= $event['id'] ?>" class="btn btn-sm btn-info">View</a>
                            <a href="event.php?page=edit&id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="event.php?page=delete&id=<?= $event['id'] ?>" 
                               onclick="return confirm('Are you sure?')" 
                               class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>You haven’t created any events yet.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
