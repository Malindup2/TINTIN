    <?php
    /**
     * My Orders Page
     * Displays user's order history organized by status
     */
    
    require 'conn.php';
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); 
        exit;
    }

    $uid = $_SESSION['user_id']; 

    // Define order status categories
    $statuses = [
        'To Be Paid' => 'Pending',
        'Processing' => 'processing',
        'Shipped' => 'shipped',
        'Finished' => 'finished',
        'Canceled' => 'canceled',
    ];

    // Fetch orders by status
    $ordersByStatus = [];
    foreach ($statuses as $key => $value) {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE uid = ? AND status = ? ORDER BY order_id DESC");
        $stmt->bind_param("is", $uid, $value);
        $stmt->execute();
        $ordersByStatus[$key] = $stmt->get_result();
    }

    // Cancel Order Handler
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
        $orderId = intval($_POST['cancel_order_id']);
        $stmt = $conn->prepare("UPDATE orders SET status = 'canceled' WHERE order_id = ? AND uid = ?");
        $stmt->bind_param("ii", $orderId, $uid);
        $stmt->execute();
        header("Location: cancel_order.php");
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Orders</title>
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

            .orders-wrapper {
                margin-left: 270px;
                padding-top: 20px;
            }

            .nav-tabs .nav-link.active {
                background-color: #ff6f61;
                color: #fff;
                font-weight: bold;
            }

            .card {
                border-left: 5px solid #007bff;
            }

            .btn-view {
                background-color: #007bff;
                color: white;
                margin-right: 10px;
            }

            .btn-cancel {
                background-color: #dc3545;
                color: white;
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

            <!-- Orders Section -->
            <div class="container orders-wrapper">
                <h3 class="fw-bold mb-4">My Orders</h3>
                
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="orderTabs" role="tablist">
                    <?php foreach (array_keys($statuses) as $index => $status): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="<?= strtolower(str_replace(' ', '-', $status)) ?>-tab"
                                    data-bs-toggle="tab" data-bs-target="#<?= strtolower(str_replace(' ', '-', $status)) ?>" type="button" role="tab"
                                    aria-controls="<?= strtolower(str_replace(' ', '-', $status)) ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                                <?= htmlspecialchars($status) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="orderTabsContent">
                    <?php foreach ($ordersByStatus as $status => $orders): ?>
                        <div class="tab-pane fade <?= $status === 'To Be Paid' ? 'show active' : '' ?>"
                            id="<?= strtolower(str_replace(' ', '-', $status)) ?>" role="tabpanel"
                            aria-labelledby="<?= strtolower(str_replace(' ', '-', $status)) ?>-tab">
                            <?php if ($orders->num_rows > 0): ?>
                                <?php while ($order = $orders->fetch_assoc()): ?>
                                    <div class="card mb-3 shadow-sm p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="fw-bold">Order #<?= htmlspecialchars($order['order_id']) ?></h5>
                                                <p class="mb-1"><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
                                                <p class="mb-1"><strong>Total:</strong> Rs. <?= htmlspecialchars($order['bill']) ?></p>
                                            </div>
                                            <div>
                                                <a href="view_order.php?order_id=<?= $order['order_id'] ?>" class="btn btn-view btn-sm">View</a>
                                                <?php if ($status !== 'Canceled' && $status !== 'Finished'): ?>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="cancel_order_id" value="<?= $order['order_id'] ?>">
                                                        <button type="submit" class="btn btn-cancel btn-sm">Cancel</button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="alert alert-info">No orders found in this category.</div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
                                