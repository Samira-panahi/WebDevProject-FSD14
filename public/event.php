<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

$page = $_GET['page'] ?? 'list';
$id   = $_GET['id'] ?? null;

$authMiddleware = new AuthMiddleware();

$authMiddleware->handle();

require_once __DIR__ . '/../app/controller/EventController.php';
$controller = new EventController($pdo);

switch($page) {
    case 'list':
        $controller->index();
        break;

    case 'show':
        $controller->show($id);
        break;

    case 'create':
        $controller->create();
        break;

    case 'edit':
        $controller->edit($id);
        break;

    case 'my_events':
        $controller->myEvents();
        break;

    case 'delete':
        $controller->delete($id);
        break;

    case 'search':   
        $controller->search();
        break;

    default:
        echo "Page not found.";
        break;
}
