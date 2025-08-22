<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    /**
     * Staff Login Page
     * Login interface for staff and admin users
     */
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-card bg-white">
        <h3 class="text-center mb-4">Staff Login</h3>
        <form action="staff_login_process.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Email</label>
                <input type="text" name="email" id="username" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Login As</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="operator">Operator</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
