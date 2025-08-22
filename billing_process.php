<?php
session_start();
require 'conn.php'; // Database connection

// Process form only if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize all input data
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $province = htmlspecialchars(trim($_POST['province']));
    $address1 = htmlspecialchars(trim($_POST['address1']));
    $address2 = htmlspecialchars(trim($_POST['address2']));
    $zip = htmlspecialchars(trim($_POST['zip']));
    $pmethod = htmlspecialchars(trim($_POST['pmethod']));
    $order_id = isset($_SESSION['lastorder']) ? $_SESSION['lastorder'] : null;

    // Update order status to processing
    $updatestate = "UPDATE orders SET status = 'processing' WHERE order_id = '$order_id'";
    $conn->query($updatestate);

    // Verify order status update
    $chkstatus = "SELECT * from orders where order_id = '$order_id' and status = 'processing'";
    $result = $conn->query($chkstatus);

    echo $order_id; // Debug output

    // Validate all required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || 
        empty($province) || empty($address1) || empty($zip) || empty($pmethod) || empty($order_id)) {
        die('All required fields must be filled, and order ID must be set.');
    }

    // Insert billing address using prepared statement
    $stmt = $conn->prepare("
        INSERT INTO billing_address (
            firstname, lastname, email, phone, province, address1, address2, zip, pmethod, order_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    // Bind parameters and execute
    $stmt->bind_param(
        'sssssssssi', // Parameter types
        $firstname, $lastname, $email, $phone, $province, 
        $address1, $address2, $zip, $pmethod, $order_id
    );

    // Handle query result
    if ($stmt->execute()) {
        echo 'Billing information successfully saved.';
        header('Location: payment_success.php');
        exit();
    } else {
        echo 'Error: ' . $stmt->error;
        header('Location: payment_failed.php');
    }

    // Clean up
    $stmt->close();
    $conn->close();
}
?>