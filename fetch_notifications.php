<?php
require "conn.php"; // Database connection
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Authentication required']);
    exit();
}

// Sanitize and validate user ID
$uid = intval($_SESSION['user_id']);

// Prepare and execute query using prepared statements
$stmt = $conn->prepare("SELECT nid, message, time FROM notifications WHERE uid = ? AND is_read = 0 ORDER BY time DESC");
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database preparation failed']);
    exit();
}

$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
$current_time = new DateTime();

while ($row = $result->fetch_assoc()) {
    // Format time as relative (e.g., "5 minutes ago")
    $notification_time = new DateTime($row['time']);
    $interval = $current_time->diff($notification_time);
    $time_ago = format_interval($interval); // Custom function (see below)
    
    $notifications[] = [
        'nid' => $row['nid'],
        'message' => htmlspecialchars($row['message']),
        'time' => $time_ago,
        'timestamp' => $row['time']
    ];
}

$stmt->close();
$conn->close();

// Custom function to format time interval
function format_interval(DateInterval $interval) {
    if ($interval->y > 0) return $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago";
    if ($interval->m > 0) return $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago";
    if ($interval->d > 0) return $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
    if ($interval->h > 0) return $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
    if ($interval->i > 0) return $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
    return "Just now";
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'count' => count($notifications),
    'notifications' => $notifications
]);
?>