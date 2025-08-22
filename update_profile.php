<?php 
/**
 * Update Profile Processing
 * Handles updates to user profile information
 */

require "conn.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit();
}

$uid = $_SESSION['user_id'];

// Get form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$province = $_POST['province'];
$zip = $_POST['zip_code'];

$profilePicPath = null;
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
    $profilePic = $_FILES['profile_pic'];

    $uploadDir = "uploads/profilepictures/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileExtension = strtolower(pathinfo($profilePic['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = "user_" . $uid . "_" . time() . "." . $fileExtension;
        $targetFilePath = $uploadDir . $newFileName;

        if (move_uploaded_file($profilePic['tmp_name'], $targetFilePath)) {
            $profilePicPath = $targetFilePath;
        } else {
            echo "Error uploading profile picture.";
            exit();
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        exit();
    }
}

$sql = "UPDATE user 
        SET name = '$name', 
            phone = '$phone', 
            address1 = '$address1', 
            address2 = '$address2', 
            province = '$province', 
            zip = '$zip'";

if ($profilePicPath) {
    $sql .= ", profile_pic = '$profilePicPath'";
}

$sql .= " WHERE id = '$uid'";

$run = $conn->query($sql);

if ($run) {
    header("location: profile.php");
    exit();
} else {
    echo "Error updating profile: " . $conn->error;
}

?>
