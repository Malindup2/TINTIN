<?php   
require 'conn.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT * FROM payment_info WHERE uid = ?");
$stmt->bind_param("i", $uid); 
$stmt->execute();
$pays = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
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
        .content {
            margin-left: 270px;
            padding: 30px;
        }
        .card-info {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .card-icon {
            width: 50px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h5 class="text-warning text-center mb-4"><i class="fa-solid fa-utensils me-2"></i><a href="index.php" style="text-decoration: none; color: inherit;">TINTIN</a></h5>
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

    <!-- Main Content -->
    <div class="content">
        <h3 class="fw-bold mb-4">My Payment Options</h3>

        <!-- Display Existing Cards -->
        <?php 
        $cardIcons = [
            'visa' => 'img/cards/visa.png',
            'mastercard' => 'img/cards/mastercard.svg',
            'amex' => 'img/cards/amex.svg',
            'default' => 'img/cards/default.png'
        ];

        foreach($pays as $pay): 
            $modalEditId = "editCardModal" . $pay['c_id'];
            $modalDeleteId = "deleteCardModal" . $pay['c_id'];
            $_SESSION['c_id'] =  $pay['c_id'];
            $cardNumber = $pay['c_num'];
            if (preg_match('/^4[0-9]{6,}$/', $cardNumber)) {
                $cardIcon = $cardIcons['visa'];
            } elseif (preg_match('/^5[1-5][0-9]{5,}$/', $cardNumber)) {
                $cardIcon = $cardIcons['mastercard'];
            } elseif (preg_match('/^3[47][0-9]{5,}$/', $cardNumber)) {
                $cardIcon = $cardIcons['amex'];
            } else {
                $cardIcon = $cardIcons['default'];
            }
        ?>
        <div class="card-info d-flex justify-content-between align-items-center shadow-sm">
            <div>
                <h6 class="fw-bold mb-2">Credit / Debit Card</h6>
                <p class="mb-1">
                    <img src="<?= htmlspecialchars($cardIcon) ?>" alt="Card Icon" class="card-icon" onerror="this.src='img/cards/default.png';"> 
                    <?= htmlspecialchars($cardNumber) ?>
                </p>
                <small>Expires <?= htmlspecialchars($pay['e_date']) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CVV <?= htmlspecialchars($pay['cvv']) ?></small> 
            </div>
            <div>
                <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#<?= $modalEditId ?>">
                    <i class="fa-solid fa-pen me-1"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#<?= $modalDeleteId ?>">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="<?= $modalEditId ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="edit_card.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="cid" value="<?= htmlspecialchars($pay['c_id']) ?>">
                            <div class="mb-3">
                                <label>New Card Number</label>
                                <input type="text" name="new_cnum" maxlength="16" class="form-control" value="<?= htmlspecialchars($pay['c_num']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Expiry Date</label>
                                <input type="month" name="e_date" class="form-control" value="<?= htmlspecialchars($pay['e_date']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>CVV</label>
                                <input type="text" name="cvv" class="form-control" value="<?= htmlspecialchars($pay['cvv']) ?>" maxlength="3" required>
                            </div>
                            <div class="mb-3">
                                <label>Cardholder Name</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($pay['name']) ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="<?= $modalDeleteId ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="delete_card.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden"  name="cid" value="<?= htmlspecialchars($pay['c_id']) ?>">
                            <p>Are you sure you want to delete this card ending in <strong><?= substr($pay['c_num'], -4) ?></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Add New Card -->
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addCardModal">
            <i class="fa-solid fa-plus me-2"></i> Add New Card
        </button>

        <!-- Add Card Modal -->
        <div class="modal fade" id="addCardModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Card</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="add_card.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <input type="text" maxlength="16" name="cnum" class="form-control" placeholder="Enter card number" required>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="month" name="e_date" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">CVV</label>
                                    <input type="text" name="cvv" class="form-control" maxlength="3" placeholder="123" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cardholder Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name on card" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Card</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
