<?php
/**
 * Staff Login Processing
 * Handles authentication for admin and operator staff members
 */

session_start();

require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Determine which table to check based on role
    $table = $role === 'admin' ? 'admin' : 'operator';

    // Query user from appropriate table
    $stmt = ("SELECT * FROM $table WHERE email = '$email'");
    $result = $conn -> query($stmt);
    $user = $result->fetch_assoc();

    // Verify password and redirect to appropriate dashboard
    if ($password == $user['password']) {
        $_SESSION['user'] = $email;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: admin_dashboard.php");
            exit;
        } elseif ($role === 'operator') {
            header("Location: operator_dashboard.php");
            exit;
        }
    } else {
        // Invalid credentials
        echo "<script>
        alert('Invalid credentials! Please try again.');
        window.location.href = 'staff_login.php';
    </script>";
    }
}
?>
