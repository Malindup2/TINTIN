<?php
/**
 * Fetch Order Details Script
 * 
 * This script retrieves and displays detailed information about order items
 * for a specific order ID. It fetches item name, quantity, unit price, and
 * total price from the order_items table and displays them in a formatted table.
 * 
 * @author TINTIN E-commerce System
 * @version 1.0
 */

// Include database connection file
require("conn.php");

// Check if order_id parameter is provided via GET request
if (isset($_GET['order_id'])) {
    // Sanitize the order_id input to prevent SQL injection
    $order_id = intval($_GET['order_id']);

    // Prepare SQL query to fetch order items for the given order_id
    $sql = "SELECT item_name, quantity, unit_price, total_price FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any items were found for this order
    if ($result->num_rows > 0) {
        // Display order items in a formatted table
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>";
        
        // Loop through each order item and display it
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['item_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>" . number_format($row['unit_price'], 2) . "</td>
                    <td>" . number_format($row['total_price'], 2) . "</td>
                </tr>";
        }
        echo "</tbody>
            </table>";
    } else {
        // Display message when no items are found
        echo "<p>No items found for this order.</p>";
    }

    // Close the prepared statement to free up resources
    $stmt->close();
} else {
    // Display error message when order_id is not provided
    echo "<p>Invalid order ID.</p>";
}
?>
