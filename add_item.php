<?php
/**
 * Add Item Processing
 * Handles adding new products to the inventory system
 */

// Include database connection file
require("conn.php");

// Check if form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Handle image upload
    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;

        // Insert item into database
        $sql = "INSERT INTO items (item_name, price, description, image_path, category) 
                VALUES ('$item_name', '$price', '$description', '$image_path', '$category')";
        
        // Execute query and redirect on success
        if ($conn->query($sql)) {
            header("Location: manage_items.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Basic styling for the page */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .card {
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-success {
            background-color: #1abc9c;
            border: none;
        }
        .btn-success:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back button to manage_items.php -->
        <a href="manage_items.php" class="btn btn-secondary mb-4">&larr; Back</a>
        
        <!-- Form to add new item -->
        <div class="card">
            <h2 class="text-center mb-4">Add New Item</h2>
            <form method="post" enctype="multipart/form-data">
                <!-- Item Name -->
                <div class="form-group mb-3">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" required>
                </div>
                
                <!-- Price -->
                <div class="form-group mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                
                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                
                <!-- Category Dropdown -->
                <div class="form-group mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="Men">Men</option>
                        <option value="Sarees">Sarees</option>
                        <option value="Kids">Kids</option>
                        <option value="Handcrafts">Handcrafts</option>
                        <option value="Gifts">Gifts</option>
                    </select>
                </div>
                
                <!-- Image Upload -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-success w-100">Add Item</button>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>