<?php
require("conn.php"); // Database connection

// Handle coupon operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Add new coupon
    if (isset($_POST['add_coupon'])) {
        $c_code = htmlspecialchars($_POST['c_code'], ENT_QUOTES, 'UTF-8');
        $discount = floatval($_POST['discount']);
        
        // Validate discount range (0-100)
        if ($discount < 0 || $discount > 100) {
            die("Discount must be between 0-100");
        }

        $stmt = $conn->prepare("INSERT INTO coupons (c_code, discount) VALUES (?, ?)");
        $stmt->bind_param("sd", $c_code, $discount); // Using 'd' for double/float

        if ($stmt->execute()) {
            header("Location: manage_coupon.php?success=added");
            exit();
        }
    }
    
    // Edit existing coupon
    elseif (isset($_POST['edit_coupon'])) {
        $cid = intval($_POST['cid']);
        $c_code = htmlspecialchars($_POST['c_code'], ENT_QUOTES, 'UTF-8');
        $discount = floatval($_POST['discount']);

        $stmt = $conn->prepare("UPDATE coupons SET c_code=?, discount=? WHERE cid=?");
        $stmt->bind_param("sdi", $c_code, $discount, $cid);

        if ($stmt->execute()) {
            header("Location: manage_coupon.php?success=updated");
            exit();
        }
    }
    
    // Handle errors
    if (isset($stmt)) {
        $_SESSION['error'] = "Operation failed: " . $conn->error;
        header("Location: manage_coupon.php?error=1");
        exit();
    }
}

// Remove coupon (GET request)
elseif (isset($_GET['remove_coupon'])) {
    $cid = intval($_GET['remove_coupon']);
    
    $stmt = $conn->prepare("DELETE FROM coupons WHERE cid=?");
    $stmt->bind_param("i", $cid);
    
    if ($stmt->execute()) {
        header("Location: manage_coupon.php?success=deleted");
        exit();
    } else {
        $_SESSION['error'] = "Delete failed: " . $conn->error;
        header("Location: manage_coupon.php?error=1");
        exit();
    }
}

// Close connection
$conn->close();