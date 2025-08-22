<?php
/**
 * Database Connection Configuration
 * Establishes connection to the e-commerce database
 */

// Create database connection using mysqli
$conn = new mysqli('localhost', 'root', '', 'ecom');

// Check connection and terminate if failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>