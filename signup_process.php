<?php 
/**
 * User Registration Processing
 * Handles new user account creation with validation
 */

require "conn.php"; 

// Get user input data
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
    alert('Invalid email address! Please enter a valid email.');
    window.location.href = 'signup.php';
  </script>";
exit;
} else {
   
// Check if email already exists
$mail = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($mail);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>
        alert('Email already exists');
        window.location.href = 'signup.php';
    </script>";
} else {
    $sql = "INSERT INTO user (email, password, username) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $password, $username);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful!');
            window.location.href = 'login.php'; // Redirect to login page
        </script>";
    } else {
        echo "<script>
            alert('Error during registration.');
            window.location.href = 'signup.php';
        </script>";
    }
}

$stmt->close();
$conn->close();
}
?>
