<?php
require 'conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$uid = $_SESSION['user_id']; 


$stmt = $conn->prepare("SELECT * FROM contact WHERE uid = ? ORDER BY id DESC");
$stmt->bind_param("i", $uid);
$stmt->execute();
$contacts = $stmt->get_result();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_contact_id'])) {
    $contactId = intval($_POST['delete_contact_id']);
    $stmt = $conn->prepare("DELETE FROM contact WHERE id = ? AND uid = ?");
    $stmt->bind_param("ii", $contactId, $uid);
    $stmt->execute();
    header("Location: my_tickets.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tickets</title>
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

        .tickets-wrapper {
            length:200px;
            margin-left: 270px;
            padding-top: 20px;
            padding-right:120px;
        }

        .contact-btn {
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 1030;
        }

        .card {
            border-left: 5px solid #007bff;
            
        }

        

        .btn-delete {
            background-color: #dc3545;
            color: white;
            
        }
        .card mb-3 shadow-sm p-3{
            length:200px;

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

        <!-- Tickets Section -->
        <div class="w-100">
            <!-- Contact Button -->
            <a href="contact.php" class="btn btn-success contact-btn">Contact</a>

            <!-- Content -->
            <div class="container tickets-wrapper mt-4">
                <h3 class="fw-bold mb-4">Your Tickets</h3>

                <div>
                    <?php if ($contacts->num_rows > 0): ?>
                        <?php while ($contact = $contacts->fetch_assoc()): ?>
                            <div class="card mb-3 shadow-sm p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold">Ticket ID: <?= htmlspecialchars($contact['id']) ?></h5>
                                        <p class="mb-1"><strong>Name:</strong> <?= htmlspecialchars($contact['name']) ?></p>
                                        <p class="mb-1"><strong>Subject:</strong> <?= htmlspecialchars($contact['subject']) ?></p>
                                        <p class="mb-1"><strong>Message:</strong> <?= htmlspecialchars($contact['message']) ?></p>
                                        <p class="mb-1"><strong>Reply:</strong> <?= htmlspecialchars($contact['reply']) ?></p>
                                        <p class="mb-1"><strong>Time:</strong> <?= htmlspecialchars($contact['time']) ?></p>
                                    </div>
                                    <div>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="delete_contact_id" value="<?= $contact['id'] ?>">
                                            <button type="submit" class="btn btn-delete btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="alert alert-info">You have no tickets. Start contacting support!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
