<div class="container mt-5">
    <h2>My Profile</h2>
    <p>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</p>

    <div class="mb-4">
        <img 
            src="<?php echo BASE_URL; ?>/public/uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>"
            alt="Profile Picture" 
            class="rounded-circle" 
            style="width: 150px; height: 150px; object-fit: cover;"
        >
    </div>

    <form action="<?php echo BASE_URL; ?>/public/profile_update.php" method="POST" enctype="multipart/form-data">
        
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Update Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <hr class="my-4">

    <form action="<?php echo BASE_URL; ?>/public/logout.php" method="POST">
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>