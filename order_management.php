<?php
/**
 * Order Management System
 * Administrative interface for managing customer orders and status updates
 */

require("conn.php");

// Get all orders from database
$sql = "SELECT order_id, uid, bill, status FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .btn-primary {
            background-color: #2c3e50;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1abc9c;
        }

        .btn-secondary {
            background-color: #34495e;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #2c3e50;
        }

        .btn-success {
            background-color: #27ae60;
            border: none;
        }

        .btn-success:hover {
            background-color: #1e8449;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .table th {
            background-color: #34495e;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_dashboard.php" class="btn btn-secondary mb-4">&larr; Back</a>
        <h1>Order Management</h1>
        <table class="table table-hover table-bordered mt-4">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Bill</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['uid']; ?></td>
                            <td><?php echo ($row['bill']); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewOrderModal" onclick="fetchOrderDetails(<?php echo $row['order_id']; ?>)">View</button>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#updateStatusModal" onclick="setOrderId(<?php echo $row['order_id']; ?>)">Update Status</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No Orders Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetails">
                 
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="update_status.php">
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Select Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="Pending">Payment Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="finished">Finished</option>
                                <option value="canceled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update Status</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function fetchOrderDetails(orderId) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `fetch_order_details.php?order_id=${orderId}`, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('orderDetails').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        function setOrderId(orderId) {
            document.getElementById('order_id').value = orderId;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
