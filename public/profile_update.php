<?php

/**
 * @file
 * Public entry point for handling profile update form submissions.
 */

// Show all errors for easier debugging.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load all essential files first.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/Session.php';
require_once __DIR__ . '/../app/controller/AuthController.php';

// Start the session and instantiate the controller.
Session::start();
$authController = new AuthController();

// Call the updateProfile method to process the form data.
$authController->updateProfile();

?>