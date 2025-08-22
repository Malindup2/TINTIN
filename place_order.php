<?php
/**
 * Place Order Script
 * Processes order placement and saves order details to database
 */

require 'conn.php';
session_start();

// Get order data from POST request
$cart_items = $_POST['cart_items']; 
$uid = $_SESSION['user_id'];
$billPrice = $_SESSION['bill_price'];

// Validate required data
if (empty($cart_items) || !$uid) {
    die("Cart items or user ID is missing.");
}

// Start database transaction for order processing
$conn->begin_transaction();

try {
    // Insert main order record
    $order_query = "INSERT INTO orders (uid, status , bill) VALUES ('$uid', 'Pending' , '$billPrice')";
    if (!$conn->query($order_query)) {
        throw new Exception("Failed to insert into orders: " . $conn->error);
    }

    $order_id = $conn->insert_id;

    // Prepare statement for order items
    $item_query = $conn->prepare("INSERT INTO order_items (order_id, item_name, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");

    // Process each cart item
    foreach ($cart_items as $item) {
        $item_name = $conn->real_escape_string($item['id']); 
        $quantity = (int) $item['quantity']; 

        $product_query = "SELECT price FROM items WHERE item_name = '$item_name'";
        $product_result = $conn->query($product_query);

        if ($product_result && $product_result->num_rows > 0) {
            $product_data = $product_result->fetch_assoc();
            $unit_price = $product_data['price'];
            $total_price = $unit_price * $quantity;

            $item_query->bind_param("isidd", $order_id, $item_name, $quantity, $unit_price, $total_price);
            if (!$item_query->execute()) {
                throw new Exception("Failed to insert into order_items: " . $conn->error);
            }
        } else {
            throw new Exception("Product not found for item: $item_name");
        }
    }

    $conn->commit();

    echo "Order placed successfully!";
    header("Location: checkout.php");
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$getoid = "SELECT order_id FROM orders WHERE uid = '$uid' ORDER BY order_id DESC LIMIT 1";
$finalorder = $conn->query($getoid);

if ($finalorder && $finalorder->num_rows > 0) {
    $row = $finalorder->fetch_assoc();
    $_SESSION['lastorder'] = $row['order_id']; 
}

$conn->close();
?>
