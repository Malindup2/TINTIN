<?php
require 'conn.php'; // Database connection
session_start();

// Redirect unauthorized users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token (highly recommended)
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid request";
        header("Location: payment_info.php");
        exit();
    }

    // Get user ID from session
    $uid = $_SESSION['user_id'];
    
    // Validate and sanitize card ID
    $cid = isset($_POST['c_id']) ? intval($_POST['c_id']) : 0;
    
    // Verify the card belongs to the user before deletion
    $verifyStmt = $conn->prepare("SELECT c_id FROM payment_info WHERE c_id = ? AND uid = ?");
    $verifyStmt->bind_param("ii", $cid, $uid);
    $verifyStmt->execute();
    $verifyStmt->store_result();
    
    if ($verifyStmt->num_rows > 0) {
        // Card belongs to user - proceed with deletion
        $deleteStmt = $conn->prepare("DELETE FROM payment_info WHERE c_id = ?");
        $deleteStmt->bind_param("i", $cid);

        if ($deleteStmt->execute()) {
            $_SESSION['success'] = "Card deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete the card. Please try again.";
            error_log("Card deletion failed for user $uid: " . $deleteStmt->error);
        }
        $deleteStmt->close();
    } else {
        $_SESSION['error'] = "Card not found or unauthorized action";
    }
    
    $verifyStmt->close();
} else {
    $_SESSION['error'] = "Invalid request method";
}

header("Location: payment_info.php");
exit();
?>