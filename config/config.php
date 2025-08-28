<?php
// =================================================================
// DATABASE CONFIGURATION
// =================================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Change to your real password
define('DB_NAME', 'event_booking');
define('BASE_URL', 'http://localhost/WebDevProject-FSD14');

// =================================================================
// PDO CONNECTION
// =================================================================

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // show errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // use real prepared statements
];

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        $options
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

