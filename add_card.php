<?php  

// Include database connection file  
require 'conn.php';  

// Start session to check user login status  
session_start();  

// Redirect to login page if user is not logged in  
if(!isset($_SESSION['user_id'])){  
    header("Location: login.php");  
    exit;  
}  

// Get user ID from session  
$uid = $_SESSION['user_id'];  

// Get payment details from form submission  
$cnum = $_POST['cnum'];  
$name = $_POST['name'];  
$date = $_POST['e_date'];  
$cvv = $_POST['cvv'];  

// Insert payment info into database  
$sql = "INSERT INTO payment_info (c_num, uid, name, e_date, cvv)  
        VALUES ('$cnum', '$uid', '$name', '$date', '$cvv')";  
$result = $conn->query($sql);  

// Redirect to payment info page after insertion  
header("location: payment_info.php");  

?>  