<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Admin Dashboard
 * Main administrative interface with system statistics and management links
 */

session_start();
require 'conn.php';

// Get dashboard statistics from database
$sql1 = "SELECT COUNT(id) as no_users FROM user";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

$sql2 = "SELECT COUNT(id) as no_items FROM items";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$sql3 = "SELECT COUNT(order_id) as no_orders FROM orders";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();
?>
<head>
    <!-- Basic meta tags and Bootstrap CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Main styling for dashboard components */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        
        /* Header styling with logout button */
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
        }
        
        /* Dashboard cards with hover effects */
        .dashboard-card {
            background-color: #ffffff;
            transition: transform 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>

<body>
    <!-- Header section with logout -->
    <div class="header">
        <h1>Admin Dashboard</h1>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

    <!-- Main dashboard layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar with stats -->
            <div class="col-md-3 sidebar">
                <div class="sidebar-item">Registered Users<br><span><?php echo $row1['no_users'] ?></span></div>
                <div class="sidebar-item">Items in Store<br><span><?php echo $row2['no_items'] ?></span></div>
                <div class="sidebar-item">Active Orders<br><span><?php echo $row3['no_orders'] ?></span></div>
            </div>

            <!-- Main content area with management cards -->
            <div class="col-md-9 main-content">
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="manage_user.php" class="dashboard-card">User Management</a>
                    </div>
                    <div class="col-md-4">
                        <a href="order_management.php" class="dashboard-card">Order Details</a>
                    </div>
                    <!-- Additional management cards... -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Admin Dashboard</p>
    </div>

    <!-- JavaScript for logout confirmation -->
    <script>
    function logout() {
        if (confirm('Are you sure you want to log out?')) {
            window.location.href = 'logout.php';
        }
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
