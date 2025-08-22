<?php
/**
 * Contact Form Processing
 * Handles contact form submissions and stores inquiries in database
 */

session_start();
require 'conn.php';

// Get and sanitize user inputs
$name = htmlspecialchars(trim($_POST['name']));
$subject = htmlspecialchars(trim($_POST['subject']));
$email = htmlspecialchars(trim($_POST['email']));
$phone = htmlspecialchars(trim($_POST['phone']));
$message = htmlspecialchars(trim($_POST['message']));

// Validate required fields
if(empty($name) || empty($email) || empty($message)) {
    die("Required fields are missing");
}

// Process form based on user login status
if(isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO contact (uid, name, subject, email, phone, message) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $uid, $name, $subject, $email, $phone, $message);
} else {
    $stmt = $conn->prepare("INSERT INTO contact (name, subject, email, phone, message) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $subject, $email, $phone, $message);
}

// Execute and handle result
if($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>