<?php 

require "conn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit();
}

$uid = $_SESSION['user_id'];
$profilePicPath = null;

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
    $profilePic = $_FILES['profile_pic'];

    // Directory for profile picture uploads
    $uploadDir = "uploads/profilepictures/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // File validation
    $fileExtension = strtolower(pathinfo($profilePic['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = "user_" . $uid . "_" . time() . "." . $fileExtension;
        $targetFilePath = $uploadDir . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($profilePic['tmp_name'], $targetFilePath)) {
            $profilePicPath = $targetFilePath;

            // Update profile picture in the database
            $sql = "UPDATE user SET profile_pic = '$profilePicPath' WHERE id = $uid";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "Profile picture updated successfully!";
            } else {
                $_SESSION['message'] = "Error updating profile picture: " . $conn->error;
            }
        } else {
            $_SESSION['message'] = "Error uploading profile picture.";
        }
    } else {
        $_SESSION['message'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
} else {
    $_SESSION['message'] = "No file uploaded or there was an upload error.";
}

// Redirect to profile.php
header("Location: profile.php");
exit();
?>
