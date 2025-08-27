<?php include __DIR__ . '/../layout/header.php'; ?>


<h1>Edit Event</h1>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach($errors as $e) echo "<div>$e</div>"; ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card p-4 shadow mb-4">
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label>Event Date</label>
        <input type="datetime-local" name="event_date" class="form-control"
               value="<?= !empty($event['event_date']) ? date('Y-m-d\TH:i', strtotime($event['event_date'])) : '' ?>" required>
    </div>

    <div class="mb-3">
        <label>Capacity</label>
        <input type="number" name="capacity" class="form-control" min="1" value="<?= $event['capacity'] ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
        <img id="preview" src="<?= isset($event['image']) ? '/WebDevProject-FSD14/public/uploads/events/'.$event['image'] : '/WebDevProject-FSD14/public/uploads/events/default_event.png' ?>" class="img-thumbnail mt-2" width="150">
    </div>

    <button type="submit" class="btn btn-primary">Update Event</button>
    <a href="/WebDevProject-FSD14/public/event.php?page=list" class="btn btn-secondary">Cancel</a>
</form>

<script>
function previewImage(event) {
    let output = document.getElementById('preview');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = ()=>URL.revokeObjectURL(output.src);
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>

