<?php
/**
 * Add to Cart Functionality
 * Handles adding items to the shopping cart session
 */

// Include database connection file
require 'conn.php';

// Start session to manage cart data
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get item details from POST data
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $image_path = $_POST['image_path'];

    // Add item to cart session
    $_SESSION['cart'][] = [
        'item_name' => $item_name,
        'price' => $price,
        'image_path' => $image_path,
    ];

    // Return success response
    echo json_encode(['status' => 'success', 'message' => 'Item added to cart']);
    exit;
}

// Return error if not a POST request
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>