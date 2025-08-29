<h2 class="mb-4">Events</h2>

<div class="row">
    <?php foreach ($events as $e): ?>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <a href="event.php?page=show&id=<?= $e['id'] ?>">
                    <img src="<?= BASE_URL ?>/public/uploads/events/<?= $e['image'] ?>"
                        class="card-img-top"
                        alt="<?= htmlspecialchars($e['title']) ?>"
                        style="height:200px; object-fit:cover;">
                </a>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($e['title']) ?></h5>
                    <p class="card-text mb-1"><strong>Date:</strong> <?= $e['event_date'] ?></p>
                    <p class="card-text mb-3"><strong>Capacity:</strong> <?= $e['capacity'] ?></p>

                    <div class="mt-auto">
                        <a href="event.php?page=show&id=<?= $e['id'] ?>" class="btn btn-info btn-sm">View</a>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="event.php?page=rsvp_join" method="POST" style="display:inline;">
                                <input type="hidden" name="event_id" value="<?= $e['id'] ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Join</button>
                            </form>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-warning btn-sm">Join</a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>