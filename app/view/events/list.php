<<<<<<< HEAD

<h2 class="mb-4">Events</h2>
=======
<?php 
if(session_status() == PHP_SESSION_NONE) session_start();
include __DIR__ . '/../layout/header.php'; 
?>

<h1 class="mb-4">Events</h1>
>>>>>>> samira

<div class="row">
    <?php foreach($events as $e): ?>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
<<<<<<< HEAD
                <a href="event.php?page=show&id=<?=$e['id']?>"><img src="<?= BASE_URL ?>/public/uploads/events/<?=$e['image']?>" 
                     class="card-img-top" 
                     alt="<?=htmlspecialchars($e['title'])?>" 
                     style="height:200px; object-fit:cover;"></a>
=======
                <img src="<?= BASE_URL ?>/public/uploads/events/<?= htmlspecialchars($e['image']) ?>" 
                     class="card-img-top" 
                     alt="<?= htmlspecialchars($e['title']) ?>" 
                     style="height:200px; object-fit:cover;">
>>>>>>> samira

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($e['title']) ?></h5>
                    <p class="card-text mb-1"><strong>Date:</strong> <?= htmlspecialchars($e['event_date']) ?></p>
                    <p class="card-text mb-3"><strong>Capacity:</strong> <?= htmlspecialchars($e['capacity']) ?></p>

                    <div class="mt-auto">
<<<<<<< HEAD
                        <a href="event.php?page=show&id=<?=$e['id']?>" 
                           class="btn btn-info btn-sm">View</a>
                        <a href="<?= BASE_URL ?>/app/view/rsvp/join.php" 
                           class="btn btn-warning btn-sm">Join</a>
                
=======
                        <a href="event.php?page=show&id=<?= $e['id'] ?>" class="btn btn-info btn-sm">View</a>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $e['user_id']): ?>
                            <a href="event.php?page=edit&id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="event.php?page=delete&id=<?= $e['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        <?php endif; ?>
>>>>>>> samira
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<<<<<<< HEAD


=======
<?php include __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> samira
