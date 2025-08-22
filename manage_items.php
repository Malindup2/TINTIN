<?php
/**
 * Item Management Interface
 * Administrative tool for managing store inventory and products
 */

session_start();

require("conn.php");

// Get all items from database
$sql = "SELECT id, item_name, price, category FROM items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
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

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
        }

        .add-item-btn {
            background-color: #1abc9c;
            color: white;
            border: none;
        }

        .add-item-btn:hover {
            background-color: #16a085;
        }

        .table th {
            background-color: #34495e;
            color: white;
            text-align: center;
        }

        .action-buttons a {
            margin-right: 5px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
    <h1>Item Management</h1>
        <div class="row mb-4 button-container">
            <div class="col-auto">
                <a href="admin_dashboard.php" class="btn btn-secondary">&larr; Back</a>
            </div>
            <div class="col-auto">
                <a href="add_item.php" class="btn add-item-btn btn-lg">+ Add New Item</a>
            </div>
        </div>
        
        <table class="table table-hover table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $row['id']; ?></td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td class="text-center action-buttons">
                                <a href="manage_item_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Manage</a>
                                <a href="delete_item.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No Items Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>