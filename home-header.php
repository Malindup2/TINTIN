<?php
/**
 * Home Header Component
 * Navigation header for logged-in users with account features
 */
?>

<script src="js/jquery-2.1.1.min.js"></script>
	<link href="css/global.css" rel="stylesheet">
	
    <script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">

<style>
.notification-dot {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
}

.notification-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.notification-item p {
    margin: 0;
    font-size: 14px;
}


</style>
<div class="whole">
<section id="top">
 <div class="container">
  <div class="row">
   <div class="top_1 clearfix">
    <div class="col-sm-3">
	 <div class="top_1l clearfix">
	  <h5 class="mgt"><i class="fa fa-headphones col_1"></i> <a href="#"> +94 77000000</a></h5>
	 </div>
	</div>
	<div class="col-sm-3">
	 <div class="top_1l clearfix">
	  
	 </div>
	</div>
	<div class="col-sm-6">
	 <div class="top_1r text-right clearfix">
	  <ul class="mgt">
	   
	   
	   
	   <li class="border_none"><i class="fa fa-power-off col_1"></i> <a href="logout.php"> Logout</a></li>
	  </ul>
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="header">
 <div class="container">
  <div class="row">
   <div class="header_1 clearfix">
    <div class="col-sm-2">
	 <div class="header_1l clearfix">
	  <h3><a href="index.php">TINTIN</a></h3>
	 </div>
	</div>
	<div class="col-sm-7">
    <form method="post" action="product_search.php">
    <div class="header_1m text-center clearfix">
        <!-- Category Filter Dropdown -->
        <select class="form-control form_1" name="filter">
            <option value="">All categories</option>
            <option value="Sarees">Sarees</option>
            <option value="Men">Men's Fashion</option>
            <option value="Gifts">Gifts</option>
            <option value="Handcrafts">Handcrafts</option>
            <option value="Kids">Kids</option>
        </select>

        <!-- Search Bar -->
        <div class="input-group">
            <input name="search" type="text" class="form-control form_2" placeholder="Search Products Here...">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </div>
</form>

	</div>
	<?php

require ('conn.php'); 


if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    $query = "SELECT * FROM notification WHERE uid = ? ORDER BY time DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
} else {
    echo "Please log in to see notifications.";
    exit();
}
?>
<div class="col-sm-3">
    <div class="header_1r clearfix">
        <ul class="nav navbar-nav mgt navbar-right">
            <li><a class="tag_m1" href="wishlist.php"><i class="fa fa-heart-o"></i></a></li>
            <li><a class="tag_m1" href="profile.php"><i class="fa fa-user"></i></a></li>
            <li class="dropdown">
                <a class="tag_m1" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <?php
                    // Check if there are new notifications
                    $newNotifications = array_filter($notifications, function ($n) {
                        return $n['time'] > (new DateTime())->modify('-1 day')->format('Y-m-d H:i:s'); // Adjust condition as needed
                    });
                    if (count($newNotifications) > 0) {
                        echo '<span class="notification-dot"></span>'; 
                    }
                    ?>
                </a>
                <ul class="dropdown-menu drop_1" role="menu">
                    <li>
                        <div class="drop_1i clearfix">
                            <div class="col-sm-6">
                                <div class="drop_1il clearfix">
                                    <h5 class="mgt">NOTIFICATIONS</h5>
                                </div>
                            </div>
                        </div>
                        <div id="notification-list">
                            <?php if (!empty($notifications)) { ?>
                                <?php foreach ($notifications as $notification) { ?>
                                    <div class="notification-item">
                                        <p><strong>Order #<?php echo $notification['oid']; ?>:</strong> <?php echo $notification['message']; ?></p>
                                        <small><?php echo date("F j, Y, g:i a", strtotime($notification['time'])); ?></small>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <p>No notifications to display.</p>
                            <?php } ?>
                        </div>
                        <div class="drop_1i3 text-center clearfix">
                            <div class="col-sm-12">
                                <h5><a class="button" href="#">VIEW ALL NOTIFICATIONS</a></h5>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>


   </div>
  </div>
 </div>
</section>

<section id="menu" class="clearfix cd-secondary-nav">
	<nav class="navbar nav_t">
		<div class="container">
		    <div class="navbar-header page-scroll">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html"> TINTIN </a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form method="POST" id="catform" action="product_filter1.php">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="m_tag1" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-bars"></i> CATEGORIES
                        </a>
                        <ul class="dropdown-menu drop_2" role="menu">
                            
                            <li><a href="#" onclick="setCategoryAndSubmit('Sarees')">Sarees</a></li>
                            <li><a href="#" onclick="setCategoryAndSubmit('Men')">Men's Fashion</a></li>
                            <li><a href="#" onclick="setCategoryAndSubmit('Gifts')">Gifts</a></li>
                            <li><a href="#" onclick="setCategoryAndSubmit('Kids')">For Kids</a></li>
                            <li><a href="#" onclick="setCategoryAndSubmit('Handcrafts')">Handcrafts</a></li>
                        </ul>
                    </li>
                    <li><a class="m_tag active_tab" href="index.php">Home</a></li>
                    <li><a class="m_tag" href="product.php">Shop</a></li>
                    <li><a class="m_tag" href="contact.php">Contact</a></li>
                    <li><a class="m_tag" href="cart.php">Cart</a></li>
                    <li><a class="m_tag" href="profile.php">Profile</a></li>
                    <li><a class="m_tag" href="logout.php">Log out</a></li>
                </ul>
            
                <input type="hidden" name="filter" id="filterInput">
            </form>



			</div>
			
		</div>
	
	</nav>
	
	</section>

</div>
<script>
    // JavaScript function to set the category and submit the form
    function setCategoryAndSubmit(category) {
        document.getElementById('filterInput').value = category;
        document.getElementById('catform').submit();
    }
</script>
	<script>
$(document).ready(function(){
	/*****Fixed Menu******/
	var secondaryNav = $('.cd-secondary-nav'),
	   secondaryNavTopPosition = secondaryNav.offset().top;
		$(window).on('scroll', function(){
			if($(window).scrollTop() > secondaryNavTopPosition ) {
				secondaryNav.addClass('is-fixed');	
			} else {
				secondaryNav.removeClass('is-fixed');
			}
		});	
		
});

function fetchNotifications() {
	
    fetch('/get-notifications.php') 
        .then(response => response.json())
        .then(data => {
            const notificationList = document.getElementById('notification-list');
            notificationList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(notification => {
                    const notificationItem = `
                        <div class="drop_1i1 clearfix">
                            <div class="col-sm-12">
                                <div class="drop_1i1l clearfix">
                                    <h6 class="mgt bold">${notification.message}</h6>
                                    <span class="normal col_2">${new Date(notification.time).toLocaleString()}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    notificationList.insertAdjacentHTML('beforeend', notificationItem);
                });
            } else {
                notificationList.innerHTML = '<p class="text-center">No notifications</p>';
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
}


document.addEventListener("DOMContentLoaded", fetchNotifications);
</script>

