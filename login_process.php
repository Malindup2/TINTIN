<?php
/**
 * Login Processing Script
 * Handles user authentication and session management
 */

require "conn.php"; 

// Get and sanitize user input
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Check if user exists in database
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify password
    if ($password == $user['password']) {
        // Start session and store user data
        session_start();
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['username'] = $user['username']; 

        echo "<script>
            alert('Login successful! Welcome, {$user['username']}');
            window.location.href = 'profile.php';
        </script>";
            
    } else {
        // Invalid credentials
        echo "<script>
            alert('Invalid details please check and try again');
            window.location.href = 'signup.php';
        </script>";
    }   
}

$stmt->close();
$conn->close();
?>
