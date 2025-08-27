<?php

/**
 * @file
 * Public entry point for user login.
 */

// Show all errors for easier debugging.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load all necessary files FIRST.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/Session.php';
require_once __DIR__ . '/../app/controller/AuthController.php';

Session::start();
$authController = new AuthController();

// Check if the form was submitted (POST) or if the page is being viewed (GET).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->login();
} else {
    // Assemble the page for viewing.
    require_once __DIR__ . '/../app/view/layout/header.php';
    require_once __DIR__ . '/../app/view/auth/login.php';
    require_once __DIR__ . '/../app/view/layout/footer.php';
}