<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/helpers/Session.php';
require_once __DIR__ . '/../../app/controller/AdminController.php';

Session::start();

// Middleware: ensure admin logged in
if (!Session::has('user_role') || Session::get('user_role') !== 'admin') {
    header("Location: " . BASE_URL . "/public/login.php");
    exit;
}

$admin = new AdminController();
$stats = $admin->dashboard();

// Render view
require_once __DIR__ . '/../../app/view/layout/header.php';
require_once __DIR__ . '/../../app/view/admin/dashboard.php';
require_once __DIR__ . '/../../app/view/layout/footer.php';
