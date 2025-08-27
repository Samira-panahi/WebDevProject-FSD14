<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <?php 
                        // Display any error or success messages
                        if (isset($_SESSION['message'])) {
                            echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
                            unset($_SESSION['message']);
                        }
                    ?>
                    <form action="<?php echo BASE_URL; ?>/public/login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/public/register.php">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>