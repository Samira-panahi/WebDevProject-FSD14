<?php

/**
 * @file
 * Public entry point for viewing and managing the user profile.
 */

// Show all errors for easier debugging.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load all essential files first.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/Session.php';
require_once __DIR__ . '/../app/model/User.php'; 

// Start the session and check for a logged-in user.
Session::start();

// If no user is logged in, redirect to the login page.
if (!Session::has('user_id')) {
    header('Location: ' . BASE_URL . '/public/login.php');
    exit();
}

// Fetch the user's data from the database.
$userModel = new User();
$user = $userModel->findById(Session::get('user_id'));

// If user data couldn't be found, handle the error.
if (!$user) {
    echo "Error: Could not retrieve user profile.";
    exit();
}

// Assemble and render the page with the user's data.
require_once __DIR__ . '/../app/view/layout/header.php';
require_once __DIR__ . '/../app/view/auth/profile.php';
require_once __DIR__ . '/../app/view/layout/footer.php';

?>