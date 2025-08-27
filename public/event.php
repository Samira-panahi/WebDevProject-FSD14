<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/controller/EventController.php';

$page = $_GET['page'] ?? 'list';
$id   = $_GET['id'] ?? null;

$controller = new EventController($pdo);
$errors = [];
$event = null;

switch($page) {

    case 'list':
        $data = $controller->index();
        $events = $data['events'];
        include __DIR__ . '/../app/view/events/list.php';
        break;

    case 'show':
        if (!$id) die("Event ID required");
        $data = $controller->show($id);
        $event = $data['event'];
        include __DIR__ . '/../app/view/events/show.php';
        break;

    case 'create':
        $errors = [];
        $event = ['title'=>'','description'=>'','event_date'=>'','capacity'=>'','image'=>'default_event.png'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $controller->create($_POST, $_FILES);

            if (empty($errors)) {
                header("Location: /WebDevProject-FSD14/public/event.php?page=list");
                exit;
            }

            $event = array_merge($event, $_POST);
            if (!empty($_FILES['image']['name'])) {
                $event['image'] = $_FILES['image']['name'];
            }
        }

        include __DIR__ . '/../app/view/events/create.php';
 
        break;

    case 'edit':
        if (!$id) die("Event ID required");

        $data = $controller->show($id);
        $event = $data['event'];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $controller->edit($id, $_POST, $_FILES);

            if (empty($errors)) {
                header("Location: /WebDevProject-FSD14/public/event.php?page=show&id=$id");
                exit;
            }
        }

        include __DIR__ . '/../app/view/events/edit.php';
        break;

    case 'delete':
        if (!$id) die("Event ID required");
        $controller->delete($id);
        header("Location: /WebDevProject-FSD14/public/event.php?page=list");
        exit;
        break;

    default:
        echo "Page not found.";
        break;
}
?>
