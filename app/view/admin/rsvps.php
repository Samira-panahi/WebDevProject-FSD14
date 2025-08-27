<?php

// ===============================
// ADMIN RSVPS PAGE WITH PAGINATION (Samira's part)
// ===============================

require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/app/controller/AdminController.php';
session_start();

// Middleware: ensure admin logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /auth/login.php");
    exit;
}

$limit = 10; // RSVPs per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Fetch total RSVPs for page count
$totalStmt = $pdo->query("SELECT COUNT(*) FROM rsvps");
$totalRsvps = $totalStmt->fetchColumn();
$totalPages = ceil($totalRsvps / $limit);

// Fetch RSVPs with JOIN (limited for current page)
$stmt = $pdo->prepare("
    SELECT r.id AS rsvp_id, e.title AS event_title, u.name AS user_name, u.profile_image, r.created_at
    FROM rsvps r
    INNER JOIN users u ON r.user_id = u.id
    INNER JOIN events e ON r.event_id = e.id
    ORDER BY r.created_at DESC
    LIMIT ? OFFSET ?
");
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$rsvps = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - RSVPs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">All RSVPs</h1>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Event</th>
            <th>User</th>
            <th>Profile</th>
            <th>RSVP Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rsvps as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['event_title']) ?></td>
                <td><?= htmlspecialchars($r['user_name']) ?></td>
                <td>
                    <img src="../../public/uploads/profiles/<?= $r['profile_image'] ?: 'default.png' ?>" width="40" height="40" style="border-radius:50%;">
                </td>
                <td><?= $r['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination links -->
    <nav>
      <ul class="pagination">
        <?php if($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
          </li>
        <?php endif; ?>

        <?php for($i=1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
