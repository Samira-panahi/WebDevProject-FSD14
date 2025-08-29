<h2 class="my-4">Search Results for: "<?= htmlspecialchars($_GET['q'] ?? '') ?>"</h2>

<?php if (!empty($results)): ?>
    <div class="row">
        <?php foreach ($results as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= BASE_URL ?>/public/uploads/<?= htmlspecialchars($event['image'] ?? 'default_event.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($event['title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                        <p class="card-text"><small class="text-muted"><?= date('M d, Y', strtotime($event['event_date'])) ?></small></p>
                        <a href="<?= BASE_URL ?>/public/event.php?page=show&id=<?= $event['id'] ?>" class="btn btn-primary">View Event</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No events found for your search.</p>
<?php endif; ?>
