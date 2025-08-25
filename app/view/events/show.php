<?php
// fetch event details
// (Belinda's part)
include '../config.php';
session_start();


?>


<?php
// RSVP FEATURE (Samira's part)

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if user already RSVP’d
    $check = $pdo->prepare("SELECT * FROM rsvps WHERE user_id = ? AND event_id = ?");
    $check->execute([$userId, $eventId]);
    $alreadyJoined = $check->fetch();

    if ($alreadyJoined) {
        // Show cancel button
        echo '<form action="/rsvp/cancel.php" method="POST">
                <input type="hidden" name="event_id" value="'.$eventId.'">
                <button type="submit">Cancel RSVP</button>
              </form>';
    } else {
        // Show join button
        echo '<form action="/rsvp/join.php" method="POST">
                <input type="hidden" name="event_id" value="'.$eventId.'">
                <button type="submit">Join Event</button>
              </form>';
    }
}

// Show participants
echo "<h3>Participants:</h3>";

$stmt = $pdo->prepare("
    SELECT u.name, u.profile_image
    FROM rsvps r
    INNER JOIN users u ON r.user_id = u.id
    WHERE r.event_id = ?
");
$stmt->execute([$eventId]);
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($participants) {
    foreach ($participants as $p) {
        $image = $p['profile_image'] ? "/uploads/profiles/".$p['profile_image'] : "/uploads/profiles/default.png";
        echo '<div style="margin-bottom:10px;">
                <img src="'.$image.'" width="40" height="40" style="border-radius:50%; margin-right:8px;">
                '.htmlspecialchars($p['name']).'
              </div>';
    }
} else {
    echo "<p>No participants yet.</p>";
}

// END of RSVP FEATURE (Samira's part)

?>
