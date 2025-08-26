<?php include __DIR__.'/../layout/header.php'; ?>

<h1 class="mb-4">Events</h1>

<table class="table table-bordered table-hover">
<thead>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Date</th>
    <th>Capacity</th>
    <th>Image</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach($events as $e): ?>
<tr>
    <td><?=$e['id']?></td>
    <td><?=htmlspecialchars($e['title'])?></td>
    <td><?=$e['event_date']?></td>
    <td><?=$e['capacity']?></td>
    <td><img src="<?= BASE_URL ?>/uploads/events/<?=$e['image']?>" width="80" class="img-thumbnail"></td>
    <td>
        <a href="<?= BASE_URL ?>/index.php?page=show&id=<?=$e['id']?>" class="btn btn-info btn-sm">View</a>
        <a href="<?= BASE_URL ?>/index.php?page=edit&id=<?=$e['id']?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="<?= BASE_URL ?>/index.php?page=delete&id=<?=$e['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php include __DIR__.'/../layout/footer.php'; ?>
