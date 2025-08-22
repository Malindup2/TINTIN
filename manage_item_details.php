<?php

require("conn.php");


$id = $_GET['id'] ?? null;
if (!$id) {
    die("Item ID is required.");
}


$sql = "SELECT * FROM items WHERE id = $id";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
    
        $item_name = $_POST['item_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];

        
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            $upload_ok = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            if ($upload_ok) {
                $image_path = $target_file;
            } else {
                die("Error uploading the image.");
            }
        } else {
   
            $image_path = $item['image_path'];
        }

       
        $updateSql = "UPDATE items SET item_name='$item_name', price='$price', category='$category', description='$description', image_path='$image_path' WHERE id=$id";
        $conn->query($updateSql);
        header("Location: manage_items.php");
    } elseif (isset($_POST['delete'])) {
        
        $deleteSql = "DELETE FROM items WHERE id=$id";
        $conn->query($deleteSql);
        header("Location: manage_items.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Item Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 50px;
            max-width: 800px;
        }

        .card {
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .image-preview {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin: 0 auto 15px auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .btn-success {
            background-color: #1abc9c;
            border: none;
        }

        .btn-success:hover {
            background-color: #16a085;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="manage_items.php" class="btn btn-secondary mb-4">&larr; Back</a>
        <div class="card">
            <img src="<?php echo $item['image_path']; ?>" alt="Item Image" class="image-preview">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $item['item_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $item['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                
                    <select name="category">
                        <option type="text" class="form-control" id="category"  value="<?php echo $item['category']; ?>"><?php echo $item['category']; ?></option>
                        <option type="text" class="form-control" id="category"  value="Men">Men's Fashion</option>
                        <option type="text" class="form-control" id="category"  value="Sarees">Sarees</option>
                        <option type="text" class="form-control" id="category"  value="Kids">Kids</option>
                        <option type="text" class="form-control" id="category"  value="Gifts">Gifts</option>
                        <option type="text" class="form-control" id="category"  value="Handcrafts">Handcrafts</option>
                        
                        
                    </select>
       
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $item['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Upload New Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
