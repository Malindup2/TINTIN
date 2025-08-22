<?php
/**
 * Support Tickets Management
 * Displays and manages customer support tickets
 */

require("conn.php");

// Get all support tickets from database
$sql = "SELECT id, uid, subject FROM contact";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Tickets</title>
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
            background-color: #34495e;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1abc9c;
        }

        .btn-secondary {
            background-color: #95a5a6;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .table th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="admin_dashboard.php" class="btn btn-secondary mb-4">&larr; Back</a>
        <h1>Support Tickets</h1>
        <table class="table table-hover table-bordered mt-4">
            <thead>
                <tr>
                    <th>CID</th>
                    <th>User ID</th>
                    <th>Subject</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo $row['id']; ?></td>
                            <td class="text-center"><?php echo $row['uid']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td class="text-center">
                                <a href="view_ticket.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No Support Tickets Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
