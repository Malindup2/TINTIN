<?php
/**
 * Wishlist Page
 * Displays user's saved/favorite items
 */

require 'conn.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$uid = $_SESSION['user_id']; 

// Get wishlist items for the user
$stmt = $conn->prepare("SELECT items.id, items.image_path, items.item_name, items.price 
                        FROM wishlist 
                        INNER JOIN items ON wishlist.item_id = items.id 
                        WHERE wishlist.user_id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #1f1f1f;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .sidebar h5 {
            font-size: 1.4rem;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar ul {
            padding-left: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            list-style: none;
        }

        .sidebar ul li a {
            display: block;
            color: #ffffff;
            text-decoration: none;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background-color: #292929;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar ul li a:hover {
            background-color: #ff9f43;
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .sidebar ul li a.active {
            background-color: #ff6f61;
            color: #fff;
            font-weight: bold;
        }

        .sidebar hr {
            border-top: 1px solid #444;
            margin: 20px 0;
        }

        .wishlist-wrapper {
            margin-left: 270px;
            padding-top: 20px;
        }

        .card-horizontal {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 6px;
            background-color: #fff;
        }

        .card-horizontal img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 6px;
        }

        .card-horizontal .card-body {
            flex-grow: 1;
        }

        .card-horizontal .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn-sm {
            margin-right: 10px;
        }

        .alert {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark sidebar p-3" id="sidebar">
            <h5 class="mb-4 text-center text-warning"><i class="fa-solid fa-utensils me-2"></i><a href="index.php" style="text-decoration: none; color: inherit;">TINTIN</a></h5>
            <ul class="list-unstyled">
                <li><a href="profile.php"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a></li>
                <li><a href="payment_info.php"><i class="fa-solid fa-credit-card me-2"></i> Payment Info</a></li>
                <li><a href="myorders.php"><i class="fa-solid fa-bag-shopping me-2"></i> My Orders</a></li>
                <hr>
                <li><a href="wishlist.php"><i class="fa-solid fa-heart me-2"></i> Wishlist</a></li>
                <li><a href="my_tickets.php"><i class="fa-solid fa-ticket me-2"></i> Your Tickets</a></li>
                <li><a href="contact.php"><i class="fa-solid fa-headset me-2"></i> Contact Support</a></li>
                <hr>
                <li><a href="product.php"><i class="fa-solid fa-store me-2"></i> Shop</a></li>
                <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Log Out</a></li>
            </ul>
        </div>

        <!-- Wishlist Section -->
        <div class="container wishlist-wrapper">
            <h3 class="fw-bold mb-4">My Wishlist</h3>

            <div>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($item = $result->fetch_assoc()): ?>
                        <div class="card-horizontal shadow-sm">
                            <img src="<?= htmlspecialchars($item['image_path'] ?: 'default_image.jpg') ?>" alt="<?= htmlspecialchars($item['item_name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item['item_name']) ?></h5>
                                <p class="card-text"><strong>Price:</strong> Rs. <?= htmlspecialchars($item['price']) ?></p>
                                <a href="product_detail.php?id=<?php echo $item['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="remove_wishlist.php?item_id=<?= htmlspecialchars($item['id']) ?>" class="btn btn-danger btn-sm">Remove</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fa-solid fa-heart text-danger"></i> Your wishlist is empty. Start adding your favorite items!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
