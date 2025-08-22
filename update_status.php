<?php
require("conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = intval($_POST['order_id']);
        $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

        $user_query = "SELECT uid FROM orders WHERE order_id = ?";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param("i", $order_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $user_id = $user['uid'];
        } else {
            echo "<script>
                alert('Invalid order ID.');
                window.location.href = 'order_management.php';
            </script>";
            exit();
        }

        $conn->begin_transaction();

        try {
            $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $status, $order_id);

            $message = "Your order #$order_id status has been updated to '$status'.";
            $insert_notification_sql = "INSERT INTO notification (uid, oid, message, time) VALUES (?, ?, ?, NOW())";
            $stmt2 = $conn->prepare($insert_notification_sql);
            $stmt2->bind_param("iis", $user_id, $order_id, $message);

            if ($stmt->execute() && $stmt2->execute()) {
                $conn->commit(); 
                echo "<script>
                    alert('Order status updated successfully.');
                    window.location.href = 'order_management.php';
                </script>";
            } else {
                throw new Exception("Failed to execute queries.");
            }
        } catch (Exception $e) {
            $conn->rollback(); 
            echo "<script>
                alert('Failed to update order status or send notification.');
                window.location.href = 'order_management.php';
            </script>";
        }

        
        $stmt->close();
        $stmt2->close();
        $user_stmt->close();
    } else {
        echo "<script>
            alert('Invalid input.');
            window.location.href = 'order_management.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid request method.');
        window.location.href = 'order_management.php';
    </script>";
}
?>
