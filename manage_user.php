<?php

session_start();
require("conn.php");

$sql = "SELECT id, email FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 50px;
        }

        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
        }

        .btn-primary {
            background-color: #2c3e50;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1abc9c;
        }

        .table th {
            background-color: #34495e;
            color: white;
            text-align: center;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Back Button -->
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">
            &larr; Back
        </a>
        <h1>User Management</h1>
        <table class="table table-hover table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $row['id']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td class="text-center">
                                <a href="manage_user_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Manage</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No Users Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>