<?php
require "conn.php";

// Check if coupon code exists in request
if (isset($_GET['code'])) {
    $couponCode = $_GET['code'];
    
    // Secure query using prepared statement
    $stmt = $conn->prepare("SELECT discount FROM coupons WHERE c_code = ?");
    $stmt->bind_param("s", $couponCode);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return JSON response based on validation
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'valid' => true, 
            'discount' => $row['discount']
        ]);
    } else {
        echo json_encode(['valid' => false]);
    }

    $stmt->close();
}

$conn->close();
?>