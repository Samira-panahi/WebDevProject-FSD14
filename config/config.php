<?php
// Database connection for Event Booking App

$host = "localhost";          
$dbname = "event_booking";    
$username = "root";
$password = "";
 
 
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // show errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // use real prepared statements
];
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        $options
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// =================================================================
// DATABASE CONFIGURATION - ELIZABETH
// =================================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Add your own password.
define('DB_NAME', 'event_booking');
define('BASE_URL', 'http://localhost/web_design_project_group1/WebDevProject-FSD14'); // Adjust BASE_URL as needed. This one is mine.


?>
