<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/controller/EventController.php';

$page = $_GET['page'] ?? 'list';
$id   = $_GET['id'] ?? null;

$controller = new EventController();
$errors = [];
$event = null;

switch($page) {

    case 'list':
        $data = $controller->index();
        $events = $data['events'];
        include '../app/view/events/list.php';
        break;

    case 'show':
        if (!$id) die("Event ID required");
        $data = $controller->show($id);
        $event = $data['event'];
        include '../app/view/events/show.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create($_POST, $_FILES);
            header("Location: ".BASE_URL."/index.php?page=list");
            exit;
        }
        $event = ['title'=>'','description'=>'','event_date'=>'','capacity'=>'','image'=>'default_event.png'];
        include '../app/view/events/create.php';
        break;

    case 'edit':
        if (!$id) die("Event ID required");
        $data = $controller->show($id);
        $event = $data['event'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->edit($id, $_POST, $_FILES);
            header("Location: ".BASE_URL."/index.php?page=show&id=$id");
            exit;
        }
        include '../app/view/events/edit.php';
        break;

    case 'delete':
        if (!$id) die("Event ID required");
        $controller->delete($id);
        header("Location: ".BASE_URL."/index.php?page=list");
        exit;
        break;

    default:
        echo "Page not found.";
        break;
}
?>
