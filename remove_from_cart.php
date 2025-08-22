<?php
/**
 * Remove from Cart
 * Removes items from the shopping cart session
 */

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemIndex = $_POST['item_index']; 

    // Remove item from cart if it exists
    if (isset($_SESSION['cart'][$itemIndex])) {
        unset($_SESSION['cart'][$itemIndex]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found in cart']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>
