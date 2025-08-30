<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

$page = $_GET['page'] ?? 'list';
$id   = $_GET['id'] ?? null;

$authMiddleware = new AuthMiddleware();



require_once __DIR__ . '/../app/controller/EventController.php';
$controller = new EventController($pdo);

switch ($page) {
    case 'list':
        $controller->index();
        break;

    case 'show':
        $controller->show($id);
        break;

    case 'search':
        $controller->search();
        break;

    case 'create':
        $authMiddleware->handle();
        $controller->create();
        break;

    case 'edit':
        $authMiddleware->handle();
        $controller->edit($id);
        break;

    case 'my_events':
        $authMiddleware->handle();
        $controller->myEvents();
        break;

    case 'delete':
        $authMiddleware->handle();
        $controller->delete($id);
        break;

    case 'rsvp_join':
        require_once __DIR__ . '/../app/controller/RsvpController.php';
        $userId = $_SESSION['user_id'] ?? null;
        $eventId = $_POST['event_id'] ?? null;
        if ($userId && $eventId) {
            $rsvpController = new RsvpController();
            $message = $rsvpController->join($userId, $eventId);
            header("Location: event.php?page=show&id=$eventId&msg=" . urlencode($message));
            exit;
        } else {
            die("Invalid request.");
        }
        break;

    case 'rsvp_cancel':
        require_once __DIR__ . '/../app/controller/RsvpController.php';
        $userId = $_SESSION['user_id'] ?? null;
        $eventId = $_POST['event_id'] ?? null;
        if ($userId && $eventId) {
            $rsvpController = new RsvpController();
            $message = $rsvpController->cancel($userId, $eventId);
            header("Location: event.php?page=show&id=$eventId&msg=" . urlencode($message));
            exit;
        } else {
            die("Invalid request.");
        }
        break;



    default:
        echo "Page not found.";
        break;
}
