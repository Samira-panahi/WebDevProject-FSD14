<?php

/**
 * @file
 * Main entry point and router for the application.
 */

// Show all errors for easier debugging.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load all essential configuration and helper files FIRST.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/Session.php';

// Start the session.
Session::start();

/*
 * Assemble and render the page.
 */
require_once __DIR__ . '/../app/view/layout/header.php';
require_once __DIR__ . '/../app/view/welcome.php';
require_once __DIR__ . '/../app/view/layout/footer.php';

?>