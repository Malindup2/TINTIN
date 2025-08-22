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
    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid request";
        header("Location: payment_info.php");
        exit();
    }

    // Get and sanitize input
    $newCardNumber = preg_replace('/[^0-9]/', '', $_POST['new_cnum']);
    $expiryDate = $_POST['e_date'];
    $cvv = preg_replace('/[^0-9]/', '', $_POST['cvv']);
    $cardholderName = htmlspecialchars(trim($_POST['name']));
    $cid = intval($_SESSION['c_id']);

    // Validate inputs
    $errors = [];
    
    if (empty($newCardNumber) || !preg_match('/^\d{13,19}$/', $newCardNumber)) {
        $errors[] = "Invalid card number";
    }
    
    if (empty($expiryDate) || !preg_match('/^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/', $expiryDate)) {
        $errors[] = "Invalid expiry date (MM/YY or MM/YYYY)";
    }
    
    if (empty($cvv) || !preg_match('/^\d{3,4}$/', $cvv)) {
        $errors[] = "Invalid CVV";
    }
    
    if (empty($cardholderName) || strlen($cardholderName) > 50) {
        $errors[] = "Invalid cardholder name";
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: payment_info.php");
        exit();
    }

    // Verify card belongs to user before updating
    $verifyStmt = $conn->prepare("SELECT c_id FROM payment_info WHERE c_id = ? AND uid = ?");
    $verifyStmt->bind_param("ii", $cid, $_SESSION['user_id']);
    $verifyStmt->execute();
    $verifyStmt->store_result();

    if ($verifyStmt->num_rows === 0) {
        $_SESSION['error'] = "Card not found or unauthorized";
        header("Location: payment_info.php");
        exit();
    }
    $verifyStmt->close();

    // Update card information
    $updateStmt = $conn->prepare("UPDATE payment_info SET c_num = ?, e_date = ?, cvv = ?, name = ? WHERE c_id = ?");
    $updateStmt->bind_param("ssssi", $newCardNumber, $expiryDate, $cvv, $cardholderName, $cid);

    if ($updateStmt->execute()) {
        $_SESSION['success'] = "Card updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update card: " . $conn->error;
        error_log("Card update failed for user {$_SESSION['user_id']}: " . $conn->error);
    }

    $updateStmt->close();
} else {
    $_SESSION['error'] = "Invalid request method";
}

$conn->close();
header("Location: payment_info.php");
exit();
?>