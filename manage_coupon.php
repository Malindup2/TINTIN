<?php
require("conn.php");


$sql = "SELECT * FROM coupons"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coupons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .btn-add {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .btn-add:hover {
            background-color: #218838;
        }
        .btn-edit {
            background-color: #007bff;
            border: none;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .btn-remove {
            background-color: #dc3545;
            border: none;
        }
        .btn-remove:hover {
            background-color: #c82333;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
       
        <a href="admin_dashboard.php" class="btn btn-back mb-4">&larr; Back</a>

      
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Manage Coupons</h1>
            <button class="btn btn-add btn-lg" data-bs-toggle="modal" data-bs-target="#addCouponModal">+ Add New Coupon</button>
        </div>

      
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>CID</th>
                    <th>Coupon Code</th>
                    <th>Discount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['cid']; ?></td>
                            <td><?php echo $row['c_code']; ?></td>
                            <td>Rs.<?php echo $row['discount']; ?></td>
                            <td class="text-center">
                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editCouponModal" onclick="fillEditForm(<?php echo $row['cid']; ?>, '<?php echo $row['c_code']; ?>', <?php echo $row['discount']; ?>)">Edit</button>
                                <a href="coupon_functions.php?remove_coupon=<?php echo $row['cid']; ?>" class="btn btn-remove btn-sm" onclick="return confirm('Are you sure you want to remove this coupon?');">Remove</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No Coupons Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Coupon Modal -->
    <div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="coupon_functions.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCouponModalLabel">Add New Coupon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newCouponCode" class="form-label">Coupon Code</label>
                            <input type="text" name="c_code" id="newCouponCode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="newDiscount" class="form-label">Discount (Rs)</label>
                            <input type="number" name="discount" id="newDiscount" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_coupon" class="btn btn-success">Add Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Coupon Modal -->
    <div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="coupon_functions.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCouponModalLabel">Edit Coupon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="cid" id="editCid">
                        <div class="mb-3">
                            <label for="editCouponCode" class="form-label">Coupon Code</label>
                            <input type="text" name="c_code" id="editCouponCode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDiscount" class="form-label">Discount (Rs)</label>
                            <input type="number" name="discount" id="editDiscount" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_coupon" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fill edit form with coupon data
        function fillEditForm(cid, c_code, discount) {
            document.getElementById('editCid').value = cid;
            document.getElementById('editCouponCode').value = c_code;
            document.getElementById('editDiscount').value = discount;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
