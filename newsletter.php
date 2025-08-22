<?php 
/**
 * Newsletter Subscription Processing
 * Handles email subscriptions for marketing newsletters
 */

session_start();
require "conn.php";

// Get and sanitize email input
$newsletter = htmlspecialchars($_POST['newsletter']);

// Insert subscription based on user login status
if (isset($_SESSION['user_id'])) {
    $uid = intval($_SESSION['user_id']); 
    $sql = "INSERT INTO newsletter (uid, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $uid, $newsletter); 
} else {
    $sql = "INSERT INTO newsletter (email) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newsletter); 
}

    
    if ($stmt->execute()) {
       
        $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
        header("Location: $previousPage");
        exit(); 
    } else {
        
        echo "Error: " . $stmt->error;
    }

  
    $stmt->close();



$conn->close();
?>
