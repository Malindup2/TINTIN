<?php
/**
 * Cancel Order Processing
 * Allows users to cancel their pending orders
 */

require 'conn.php';
session_start();

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['uid'])) {
        header("Location: login.php"); 
        exit;
    }

    // Get user ID and order ID
    $uid = $_SESSION['uid'];
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

    // Verify order belongs to user
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND uid = ?");
    $stmt->bind_param("ii", $orderId, $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Cancel the order
        $updateStmt = $conn->prepare("UPDATE orders SET status = 'canceled' WHERE order_id = ?");
        $updateStmt->bind_param("i", $orderId);
        
        // Set success/error message
        if ($updateStmt->execute()) {
            $_SESSION['message'] = "Order #$orderId has been successfully canceled.";
        } else {
            $_SESSION['error'] = "Failed to cancel Order #$orderId. Please try again.";
        }
        $updateStmt->close();
    } else {
        $_SESSION['error'] = "Order #$orderId does not exist or you are not authorized to cancel it.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request method.";
}

$conn->close();  // Close connection

// Redirect back to orders page
header("Location: orders.php");
exit;
?>