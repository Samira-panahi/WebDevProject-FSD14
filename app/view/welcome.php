<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="container text-center mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            
            <!-- You can add an image image here if you have one for the welcome page -->
            <!-- <img src="/assets/images/logo.png" alt="Event Booking Logo" class="mb-4" style="max-width: 150px;"> -->

            <h1 class="display-4">Welcome to EventHub</h1>
            <p class="lead">
                Your one-stop platform for discovering and booking events.
            </p>
            <hr class="my-4">
            <p>
                Join our community to start exploring, or log in to manage your existing RSVPs and profile.
            </p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                <a href="<?php echo BASE_URL; ?>/public/login.php" class="btn btn-primary btn-lg px-4 gap-3">Login</a>
                <a href="<?php echo BASE_URL; ?>/public/register.php" class="btn btn-outline-secondary btn-lg px-4">Register</a>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>