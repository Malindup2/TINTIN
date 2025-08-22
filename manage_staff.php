<?php
require 'conn.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $roll = $_POST['roll'];

    if ($roll === 'admin') {
        $sql = "INSERT INTO admin (email, password, fullname, roll) VALUES ('$email', '$password', '$fullname', 'admin')";
    } elseif ($roll === 'operator') {
        $sql = "INSERT INTO operator (email, password, fullname, roll) VALUES ('$email', '$password', '$fullname', 'operator')";
    }

    if ($conn->query($sql) === TRUE) {
    } 
}

// Handle deletion
if (isset($_GET['delete']) && isset($_GET['type'])) {
    $id = $_GET['delete'];
    $type = $_GET['type'];

    if ($type === 'admin') {
        $sql = "DELETE FROM admin WHERE id = $id";
    } elseif ($type === 'operator') {
        $sql = "DELETE FROM operator WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
    } 
}

// Fetch current admins and operators
$admins = $conn->query("SELECT * FROM admin");
$operators = $conn->query("SELECT * FROM operator");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 20px;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
    <script>
        function confirmDeletion(type, id) {
            if (confirm(`Are you sure you want to delete this ${type}?`)) {
                window.location.href = `?delete=${id}&type=${type}`;
            }
        }
    </script>
</head>
<body>
    <a href="admin_dashboard.php" class="btn btn-secondary back-button">Back</a>
    <div class="container">
        <h1 class="text-center mb-4">Staff Management</h1>

        <!-- Add New Admin/Operator Form -->
        <div class="card mb-4">
            <div class="card-header">Add New Admin/Operator</div>
            <div class="card-body">
                <form method="POST" id="Form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name:</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="roll" class="form-label">Role:</label>
                        <select name="roll" id="roll" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>

        <!-- Display Current Admins -->
        <h2>Current Admins</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $admins->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><button class="btn btn-danger btn-sm" onclick="confirmDeletion('admin', <?php echo $row['id']; ?>)">Delete</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <hr>

        <!-- Display Current Operators -->
        <h2>Current Operators</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $operators->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><button class="btn btn-danger btn-sm" onclick="confirmDeletion('operator', <?php echo $row['id']; ?>)">Delete</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
        document.getElementById("Form").addEventListener("submit", function (e) {
            const emailInput = document.getElementById("email");
            const email = emailInput.value.trim();

            // Stricter email regex
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailRegex.test(email)) {
                e.preventDefault(); // Prevent form submission
                alert("Please enter a valid email address ");
                emailInput.focus();
            }
        });
    </script>
<?php
$conn->close();
?>
