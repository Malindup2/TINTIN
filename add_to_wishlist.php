<?php
/**
 * Add to Wishlist
 * Adds items to user's wishlist for later purchase consideration
 */

session_start();
require 'conn.php';

// Check database connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Handle wishlist addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $uid = $_SESSION['user_id'];
    
    // Insert item into wishlist
    $query = "INSERT INTO wishlist (item_id, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $id, $uid);

    if ($stmt->execute()) {
        echo "Item added to wishlist successfully.";
    } else {
        echo "Error adding item to wishlist: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>