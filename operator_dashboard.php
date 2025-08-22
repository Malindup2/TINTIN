<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Operator Dashboard
 * Dashboard interface for operator staff with limited administrative functions
 */

session_start(); 
require 'conn.php';

// Get system statistics for dashboard
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background-color: #34495e;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .logout-btn:hover {
            background-color: #1abc9c;
            transform: scale(1.05);
        }

        .sidebar {
            background-color: #34495e;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar-item {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #2c3e50;
            text-align: center;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .sidebar-item:hover {
            background-color: #1abc9c;
        }

        .main-content {
            padding: 30px;
        }

        .dashboard-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 1.1rem;
            font-weight: 500;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: #333;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            color: #1abc9c;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Admin Dashboard</h1>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="sidebar-item">Registered Users<br><span> <?php echo $row1['no_users']  ?> </span></div>
                <div class="sidebar-item">Items in Store<br><span><?php echo $row2['no_items']  ?></span></div>
                <div class="sidebar-item">Active Orders<br><span><?php echo $row3['no_orders']  ?></span></div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="manage_items.php" class="dashboard-card">Item Management</a>
                    </div>
                    
                    <div class="col-md-4">
                        <a href="support_tickets.php" class="dashboard-card">Support Tickets</a>
                    </div>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>

   
    <div class="footer">
        <p>&copy; 2024 Admin Dashboard</p>
    </div>

    <script>
       
function logout() {
    const confirmation = confirm('Are you sure you want to log out?');
    if (confirmation) {
       
        window.location.href = 'logout.php';
    } else {
        
        console.log('Logout canceled.');
    }
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
