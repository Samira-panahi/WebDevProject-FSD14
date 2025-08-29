<?php

// ===============================
// ADMIN RSVPS PAGE WITH PAGINATION (Samira's part)
// ===============================

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../controller/AdminController.php';

// Middleware: ensure admin logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /auth/login.php");
    exit;
}

// Pagination settings
$limit = 10; // RSVPs per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// ================== FILTER / SEARCH ==================
$filters = [];
$sqlWhere = "WHERE 1=1";

if (!empty($_GET['user'])) {
    $sqlWhere .= " AND CONCAT(u.first_name,' ',u.last_name) LIKE :user";
    $filters[':user'] = "%" . $_GET['user'] . "%";
}

if (!empty($_GET['event'])) {
    $sqlWhere .= " AND e.id = :event";
    $filters[':event'] = $_GET['event'];
}

if (!empty($_GET['date'])) {
    $sqlWhere .= " AND DATE(r.created_at) = :date";
    $filters[':date'] = $_GET['date'];
}

// Fetch total RSVPs (for pagination)
$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM rsvps r
    INNER JOIN users u ON r.user_id = u.id
    INNER JOIN events e ON r.event_id = e.id
    $sqlWhere
");
$totalStmt->execute($filters);
$totalRsvps = $totalStmt->fetchColumn();
$totalPages = ceil($totalRsvps / $limit);

// Fetch RSVPs with filters, JOIN, and pagination
$sql = "
    SELECT 
        r.id AS rsvp_id, 
        e.title AS event_title, 
        CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
        u.profile_picture,
        r.created_at
    FROM rsvps r
    INNER JOIN users u ON r.user_id = u.id
    INNER JOIN events e ON r.event_id = e.id
    $sqlWhere
    ORDER BY r.created_at DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($sql);

// Bind filter values
foreach ($filters as $key => $val) {
    $stmt->bindValue($key, $val);
}

// Bind pagination
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$rsvps = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all events for filter dropdown
$events = $pdo->query("SELECT id, title FROM events")->fetchAll();

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

    <!-- ====== FILTER / SEARCH FORM ====== -->
    <form method="GET" class="mb-3">
        <input type="text" name="user" placeholder="Search by user" class="form-control d-inline w-auto" value="<?= htmlspecialchars($_GET['user'] ?? '') ?>">
        <select name="event" class="form-control d-inline w-auto">
            <option value="">All Events</option>
            <?php foreach($events as $event): 
                $selected = (isset($_GET['event']) && $_GET['event'] == $event['id']) ? 'selected' : '';
            ?>
                <option value="<?= $event['id'] ?>" <?= $selected ?>><?= htmlspecialchars($event['title']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="date" class="form-control d-inline w-auto" value="<?= $_GET['date'] ?? '' ?>">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    <!-- ====== END FILTER ====== -->

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Event</th>
            <th>User</th>
            <th>Profile</th>
            <th>RSVP Date</th>
            <th>Action</th> <!-- Added column for Delete/Cancel -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rsvps as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['event_title']) ?></td>
                <td><?= htmlspecialchars($r['user_name']) ?></td>
                <td>
                    <img src="../../public/uploads/profiles/<?= $r['profile_picture'] ?: 'default.png' ?>" width="40" height="40" style="border-radius:50%;">
                </td>
                <td><?= $r['created_at'] ?></td>

                <!-- ====== DELETE / CANCEL BUTTON ====== -->
                <td>
                    <form method="POST" action="delete_rsvp.php" onsubmit="return confirm('Are you sure you want to delete/cancel this RSVP?');">
                        <input type="hidden" name="rsvp_id" value="<?= $r['rsvp_id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete / Cancel</button>
                    </form>
                </td>
                <!-- ====== END DELETE / CANCEL ====== -->
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
