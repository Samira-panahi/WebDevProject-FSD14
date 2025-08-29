<?php
require_once __DIR__ . '/../../controller/AdminController.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: " . BASE_URL . "/public/login.php");
    exit;
}

$admin = new AdminController();
$stats = $admin->dashboard();
?>


<h1>Admin Dashboard</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3 bg-light">
            <h4>Total Users</h4>
            <p><?= $stats['users'] ?></p>
            <a href="<?php echo BASE_URL; ?>/public/admin/admin_users.php" class="btn btn-primary btn-sm">Manage Users</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-light">
            <h4>Total Events</h4>
            <p><?= $stats['events'] ?></p>
            <a href="<?php echo BASE_URL; ?>/public/admin/admin_events.php" class="btn btn-primary btn-sm">Manage Events</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-light">
            <h4>Total RSVPs</h4>
            <p><?= $stats['rsvps'] ?></p>
            <a href="<?php echo BASE_URL; ?>/public/admin/admin_rsvps.php" class="btn btn-primary btn-sm">Manage RSVPs</a>

        </div>
    </div>
</div>
