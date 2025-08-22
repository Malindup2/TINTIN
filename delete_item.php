<?php
session_start();
require("conn.php"); // Database connection

// Verify admin privileges (add your own authentication logic)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['message'] = "Unauthorized access";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

// Only process if valid numeric ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    // Sanitize and validate input
    $id = intval($_GET['id']);
    
    // Verify item exists before deletion (optional)
    $checkStmt = $conn->prepare("SELECT id FROM items WHERE id = ?");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        // Prepare delete statement
        $deleteStmt = $conn->prepare("DELETE FROM items WHERE id = ?");
        $deleteStmt->bind_param("i", $id);

        // Execute deletion
        if ($deleteStmt->execute()) {
            // Success - check affected rows
            if ($deleteStmt->affected_rows > 0) {
                $_SESSION['message'] = "Item deleted successfully.";
                $_SESSION['message_type'] = "success";
                
                // Log the deletion (recommended)
                error_log("Item ID $id deleted by user {$_SESSION['user_id']}");
            } else {
                $_SESSION['message'] = "No item was deleted.";
                $_SESSION['message_type'] = "warning";
            }
        } else {
            $_SESSION['message'] = "Database error: " . $conn->error;
            $_SESSION['message_type'] = "danger";
        }
        $deleteStmt->close();
    } else {
        $_SESSION['message'] = "Item not found.";
        $_SESSION['message_type'] = "warning";
    }
    $checkStmt->close();
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger";
}

// Redirect back to management page
header("Location: manage_items.php");
exit();