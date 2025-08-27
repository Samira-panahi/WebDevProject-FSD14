<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/app/controller/AdminController.php';



session_start();

// Middleware: ensure admin logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /auth/login.php");
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
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 bg-light">
            <h4>Total Events</h4>
            <p><?= $stats['events'] ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 bg-light">
            <h4>Total RSVPs</h4>
            <p><?= $stats['rsvps'] ?></p>
        </div>
    </div>
</div>
