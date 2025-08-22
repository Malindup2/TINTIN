<?php
require 'conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$uid = $_SESSION['user_id']; 
$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$orderItems = $stmt->get_result();

if ($orderItems->num_rows === 0) {
    $_SESSION['error'] = "Order #$orderId does not exist or you are not authorized to view it.";
    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #1f1f1f;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .sidebar h5 {
            font-size: 1.4rem;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar ul {
            padding-left: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            list-style: none;
        }

        .sidebar ul li a {
            display: block;
            color: #ffffff;
            text-decoration: none;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background-color: #292929;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar ul li a:hover {
            background-color: #ff9f43;
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .sidebar ul li a.active {
            background-color: #ff6f61;
            color: #fff;
            font-weight: bold;
        }

        .sidebar hr {
            border-top: 1px solid #444;
            margin: 20px 0;
        }

        .orders-wrapper {
            margin-left: 270px;
            padding: 20px;
        }

        .card {
            border-left: 5px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark sidebar p-3" id="sidebar">
            <h5 class="mb-4 text-center text-warning"><i class="fa-solid fa-utensils me-2"></i>TINTIN</h5>
            <ul class="list-unstyled">
                <li><a href="#"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a></li>
                <li><a href="payment_info.php"><i class="fa-solid fa-credit-card me-2"></i> Payment Info</a></li>
                <li><a href="orders.php" class="active"><i class="fa-solid fa-bag-shopping me-2"></i> My Orders</a></li>
                <hr>
                <li><a href="#"><i class="fa-solid fa-heart me-2"></i> Wishlist</a></li>
                <li><a href="#"><i class="fa-solid fa-ticket me-2"></i> Your Tickets</a></li>
                <li><a href="#"><i class="fa-solid fa-headset me-2"></i> Contact Support</a></li>
                <hr>
                <li><a href="#"><i class="fa-solid fa-right-from-bracket me-2"></i> Log Out</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container orders-wrapper">
            <a href="myorders.php" class="btn btn-secondary mb-4"><i class="fa-solid fa-arrow-left me-2"></i> Back</a>
            <h3 class="fw-bold mb-4">Order Details - #<?= htmlspecialchars($orderId) ?></h3>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $orderItems->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['item_name']) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td>Rs. <?= number_format($item['unit_price'], 2) ?></td>
                                <td>Rs. <?= number_format($item['total_price'], 2) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
