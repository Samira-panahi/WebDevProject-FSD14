<?php

/**
 * @file
 * Public entry point for handling user logout.
 */

// Load essential files
require_once __DIR__ . '/../app/controller/AuthController.php';
require_once __DIR__ . '/../config/config.php';

// Instantiate the controller and call the logout method
$authController = new AuthController();
$authController->logout();

?>