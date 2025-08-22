<!DOCTYPE html>
<?php 
/**
 * User Profile Page
 * Displays user account information and profile management options
 */

require 'conn.php';
session_start();

// Check if user is logged in and get user data
if(isset($_SESSION['user_id'])){
    $uid = $_SESSION['user_id'];
    $sql = "SELECT * from user where id = $uid";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
    
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
<style>.sidebar {
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

.profile-wrapper {
    margin-left: 270px;
    width: calc(100% - 270px);
}
</style>
</head>
<body>
    <!-- Sidebar and Main Content Wrapper -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark sidebar p-3" id="sidebar">
        <h5 class="mb-4 text-center text-warning"><i class="fa-solid fa-utensils me-2"></i><a href="index.php" style="text-decoration: none; color: inherit;">TINTIN</a></h5>
            <ul class="list-unstyled">
                <li><a href="#"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a></li>
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

        <!-- Main Profile Section -->
        <div class="container my-5 profile-wrapper">
            <h3 class="fw-bold mb-4">Profile</h3>
            <div class="row">
                <!-- Profile Sidebar -->
                                <!-- Profile Sidebar -->
                <div class="col-md-4 text-center profile-card shadow-sm p-4">
                    <form action="update_profile_pic.php" method="POST" enctype="multipart/form-data">
                        <div class="profile-img-wrapper">
                            <label for="profilePicUpload" style="cursor: pointer;">
                                <img 
                                    src="<?php echo $row['profile_pic'] ?: 'https://via.placeholder.com/150'; ?>" 
                                    alt="Profile Picture" 
                                    class="rounded-circle profile-img" 
                                    id="profileImage">
                            </label>
                            <input type="file" name="profile_pic" id="profilePicUpload" style="display: none;" onchange="updateProfileImage(event)">
                        </div>
                        <h4 class="fw-bold profile-name"><?php echo $row['name']; ?></h4>
                        <p class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $row['address1']; ?></p>
                        <p class="text-muted"><?php echo $row['address2']; ?></p>
                        <span class="text-warning mb-2 d-block"><i class="fa-solid fa-star"></i> 5.0 (1)</span>

                      
                        <button type="submit" name="update_picture" class="btn btn-outline-danger btn-sm mt-2">Update Picture</button>

                       
                    </form>
                </div>


               
                <div class="col-md-8 profile-content shadow-sm p-4">
                    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                        <h5 class="fw-bold mb-3">User Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Name </label>
                            <input type="text" pattern="[A-Za-z\s]+"    name="name" class="form-control" value="<?php echo  $row['name'] ; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"   name="email" class="form-control" value="<?php echo  $row['email'] ; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo  $row['phone'] ; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address Line 1</label>
                            <input type="text" name="address1" class="form-control" value="<?php echo  $row['address1'] ; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" name="address2" class="form-control" value="<?php echo  $row['address2'] ; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Province</label>
                            <select name="province" class="form-control">
                                <option value="">-- Select Province --</option>
                                <option value="Central" <?php if($row['province'] == "Central") echo "selected"; ?>>Central</option>
                                <option value="Eastern" <?php if($row['province'] == "Eastern") echo "selected"; ?>>Eastern</option>
                                <option value="North Central" <?php if($row['province'] == "North Central") echo "selected"; ?>>North Central</option>
                                <option value="Northern" <?php if($row['province'] == "Northern") echo "selected"; ?>>Northern</option>
                                <option value="North Western" <?php if($row['province'] == "North Western") echo "selected"; ?>>North Western</option>
                                <option value="Sabaragamuwa" <?php if($row['province'] == "Sabaragamuwa") echo "selected"; ?>>Sabaragamuwa</option>
                                <option value="Southern" <?php if($row['province'] == "Southern") echo "selected"; ?>>Southern</option>
                                <option value="Uva" <?php if($row['province'] == "Uva") echo "selected"; ?>>Uva</option>
                                <option value="Western" <?php if($row['province'] == "Western") echo "selected"; ?>>Western</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" value="<?php echo  $row['zip'] ; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateProfileImage(event) {
    const input = event.target;
    const profileImage = document.getElementById('profileImage');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            profileImage.src = e.target.result; // Update the profile image preview
        };
        reader.readAsDataURL(input.files[0]);
    }
}


        function confirmAccountClosure() {
            if (confirm("Are you sure you want to close your account? This action cannot be undone!")) {
                window.location.href = 'delete_account.php?<?php echo $row['user_id'] ?>';
            }
        }
    </script>
</body>
</html>

    
<?php
} else {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}
?>