<?php

// define('BASE_URL', rtrim(dirname($_SERVER['PHP_SELF']), '/'));


// define('DB_HOST', 'localhost');
// define('DB_NAME', 'event_booking');
// define('DB_USER', 'root');
// define('DB_PASS', "123bel...");

$host = "localhost";          
$dbname = "event_booking";    
$username = "root";
$password = "123bel...";
 
 
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
?>