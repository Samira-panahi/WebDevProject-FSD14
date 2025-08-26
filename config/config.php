<?php

define('BASE_URL', rtrim(dirname($_SERVER['PHP_SELF']), '/'));


require_once __DIR__ . '/pass.php';

define('DB_HOST', 'localhost');
define('DB_NAME', 'event_booking');
define('DB_USER', 'root');
define('DB_PASS', $password);

?>