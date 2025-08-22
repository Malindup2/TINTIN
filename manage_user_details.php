<?php

session_start();
require("conn.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    die("User ID is required.");
}

$sql = "SELECT * FROM user WHERE id = $id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $province = $_POST['province'];
        $zip = $_POST['zip'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
            alert('Invalid email address! Please enter a valid email.');
            window.location.href = 'manage_user.php';
          </script>";
        exit; 
        } else {
        $updateSql = "UPDATE user SET email='$email', password='$password', username='$username', name='$name', phone='$phone', address1='$address1', address2='$address2', province='$province', zip='$zip' WHERE id=$id";
        $conn->query($updateSql);
        header("Location: manage_user.php"); }
    } elseif (isset($_POST['delete'])) {
        $deleteSql = "DELETE FROM user WHERE id=$id";
        $conn->query($deleteSql);
        header("Location: manage_user.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMwGgdbJ3zNa+K9lvYF/UbsfUw5G7d3eBwlHr5" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 50px;
            max-width: 900px;
        }

        .card {
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-pic {
            max-width: 120px;
            border-radius: 10px;
            margin-right: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .position-relative .fa-eye {
            position: absolute;
            cursor: pointer;
            top: 50%;
            transform: translateY(-50%);
            right: 15px;
            color: #6c757d;
        }

        .btn-success {
            background-color: #1abc9c;
            border: none;
        }

        .btn-success:hover {
            background-color: #16a085;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-secondary {
            background-color: #34495e;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #2c3e50;
        }

        .header-group {
            display: flex;
            align-items: center;
        }

        .header-info {
            flex: 1;
        }
    </style>
</head>

<body>
    <form method="post">
    <div class="container">
        <a href="manage_user.php" class="btn btn-secondary mb-4">Back</a>
        <div class="card">
            <div class="header-group mb-4">
                <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Picture" class="profile-pic">
                <div class="header-info">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" pattern="[A-Za-z\s]+" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>" required>
                    </div>
                </div>
            </div>

            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="address1" class="form-label">Address 1</label>
                            <input type="text" class="form-control" id="address1" name="address1" value="<?php echo $user['address1']; ?>" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address2" class="form-label">Address 2</label>
                            <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $user['address2']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="<?php echo $user['province']; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="zip" class="form-label">Zip Code</label>
                            <input type="number" class="form-control" id="zip" name="zip" value="<?php echo $user['zip']; ?>" >
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                </div>
           
        </div>
    </div>
    </form>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye-slash');
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>
