<?php
require_once 'conn.php'; // Database connection

// Only process if user_id is provided and user is authorized
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    
    // Start session if needed for authorization checks
    session_start();
    
    // Verify admin privileges (example)
    if (!isset($_SESSION['is_admin'])) {
        die("Unauthorized access");
    }

    // Validate and sanitize input
    $id = intval($_GET['user_id']); // Force integer type
    
    // Use prepared statement for security
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute and handle result
    if ($stmt->execute()) {
        // Success - redirect with success message
        $_SESSION['message'] = "User account deleted successfully";
        header("Location: index.php");
        exit();
    } else {
        // Error handling
        $_SESSION['error'] = "Error deleting user: " . $conn->error;
        header("Location: index.php");
        exit();
    }
    
    // Clean up
    $stmt->close();
    $conn->close();
} else {
    // Invalid request
    header("Location: index.php");
    exit();
}
?>