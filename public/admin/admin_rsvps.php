<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/helpers/Session.php';

Session::start();

// Only admins allowed
if (!Session::has('user_role') || Session::get('user_role') !== 'admin') {
    header("Location: " . BASE_URL . "/public/login.php");
    exit;
}


// Render view
require_once __DIR__ . '/../../app/view/layout/header.php';
require_once __DIR__ . '/../../app/view/admin/rsvps.php';
require_once __DIR__ . '/../../app/view/layout/footer.php';


