<?php

require "conn.php";



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['item_image']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    
    // Check if the uploaded file is an image
    $check = getimagesize($_FILES['item_image']['tmp_name']);
    if ($check === false) {
        die("File is not an image.");
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($_FILES['item_image']['tmp_name'], $uploadFile)) {
        die("Error uploading the file.");
    }

  
    $itemName = $conn->real_escape_string($_POST['item_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $category = $conn->real_escape_string($_POST['category']);

    
    $sql = "INSERT INTO items (image_path, item_name, price, category) VALUES ('$uploadFile', '$itemName', '$price', '$category')";
    if ($conn->query($sql) === TRUE) {
        echo "New item inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
