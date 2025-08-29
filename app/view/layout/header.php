<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/public/">Menu</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/public/">Home</a>
                    </li>

                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/public/event.php?page=my_events">My Events</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/public/event.php?page=create">Create Event</a>
                    </li>

                    <?php // Check if user is logged in by verifying session variable to display appropriate options in navbar 
                    ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/public/profile.php">My Profile</a>
                        </li>
                        <!-- samira --- Admin Dashboard link for admin users only -->
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/public/admin/admin.php">Admin Dashboard</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <form action="<?php echo BASE_URL; ?>/public/logout.php" method="POST" class="d-flex">
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/public/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/public/register.php">Register</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>
    </nav>
    <div class="container">