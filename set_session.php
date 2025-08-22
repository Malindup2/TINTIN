<?php
session_start();

// Read the raw JSON data sent from the client
$data = json_decode(file_get_contents("php://input"), true);

// Check if the value is set
if (isset($data['bill_price'])) {
    $_SESSION['bill_price'] = $data['bill_price'];
    
} 
?>
