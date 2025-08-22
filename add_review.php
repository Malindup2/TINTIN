<?php
// Start session (if needed for user authentication)
session_start();

// Include database connection file
require 'conn.php';

// Get form data from POST request
$id = $_POST['id'];          // Item ID
$name = $_POST['name'];      // Reviewer's name
$email = $_POST['email'];    // Reviewer's email
$messege = $_POST['messege']; // Review message (Note: 'messege' is misspelled, should be 'message')
$rating = $_POST['rating'];  // Rating (e.g., 1-5 stars)

// SQL query to insert review into database
$review = "INSERT INTO item_review (item_id, name, email, messege, rating) 
           VALUES ('$id', '$name', '$email', '$messege','$rating')";

// Execute query and check if successful
if ($conn->query($review) {
    // Redirect back to the previous page on success
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    // Optional: Handle error (e.g., log or display error)
    // echo "Error: " . $conn->error;
}
?>