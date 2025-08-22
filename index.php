<!DOCTYPE html>
<html>
	
	<?php 
	/**
	 * Home Page - Main landing page for TINTIN E-commerce
	 * Displays featured products, categories, and promotional content
	 */
	
	session_start();

	// Check if user is logged in and include appropriate header
	if(isset($_SESSION['user_id'])){
		require "home-header.php";
	}else{
		require "visitor-header.php";
	}
	 ?>
	
</html>

<html lang="en">	

  <head>
 
    <title>TINTIN</title>
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	
    
	
  </head>
  
<body>
<?php 
require "conn.php";

// Database queries to fetch different categories of items for homepage display

// Fetch men's items (limited to 4)
$qmen = "SELECT * FROM items WHERE category like 'Men' limit 4	 ";
$mens = $conn -> query($qmen);

// Fetch sarees (limited to 4)
$qsaree = "SELECT * FROM items WHERE category like 'Sarees'limit 4";
$sarees = $conn -> query($qsaree);

// Fetch kids items (limited to 4)
$qkids = "SELECT * FROM items WHERE category like 'Kids' limit 4";
$kids = $conn ->query($qkids);

// Fetch gifts (limited to 4)
$qgifts = "SELECT * FROM items WHERE category like 'Gifts' limit 4";
$gifts = $conn ->query($qgifts);

// Fetch handcrafts (limited to 4)
$qhand = "SELECT * FROM items WHERE category like 'Handcrafts' limit 4";
$handcrafts = $conn -> query($qhand);

// Fetch sale items - cheapest products first
$qsale = "SELECT * From items
		  ORDER BY price 
		  limit 3 ";
$sale = $conn -> query($qsale);

// Fetch new arrivals - newest products first
$qarrive = "SELECT * From items
		  ORDER BY Date DESC
		  limit 3 ";
$arrive = $conn -> query($qarrive);

// Fetch random top products
$qtop = "SELECT * From items
		  ORDER BY  RAND()
		  limit 3 ";
$top = $conn -> query($qtop);
?>
<section id="center" class="center_home clearfix">
 <div class="container">
  <div class="row">
   <div class="center_home clearfix">
    <div class="col-sm-4">
	 <div class="center_homer clearfix">
	  <img src="img/saree-home.jpg" class="iw" alt="abc">
	 </div>
	</div>
	<div class="col-sm-4">
	 <div class="center_homem clearfix">
	  <h4 class="mgt">UP TO 30% OFF</h4>
	  <h1 class="col_1">On selected products</h1>
	  <p>Your wardrobe upgrade is just a click away.</p>
      <h5><a class="button" href="product.php">SHOP NOW!</a></h5>
	 </div>
	</div>
	<div class="col-sm-4">
	 <div class="center_homer clearfix">
	  <img src="img/home-top-left.jpg" class="iw" alt="abc">
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="collection">
 <div class="container">
  <div class="row">
   <div class="collect_1 clearfix">
    <div class="col-sm-4">
	 <div class="collect_1l clearfix">
	  <div class="col-sm-6 space_all">
	   <div class="collect_1ll clearfix">
	    <h5 class="mgt col_1">Man's Collectons</h5>
		<h4>Calsual waers on sale</h4>
		<h5><a href="product.php"> DISCOVER NOW</a></h5>
	   </div>
	  </div>
	  <div class="col-sm-6 space_all">
	   <div class="collect_1lr clearfix">
	    <img src="img/BOSS Spring 2019 Men's Collection.jpg" alt="abc" class="iw">
	   </div>
	  </div>
	 </div>
	</div>
	<div class="col-sm-4">
	 <div class="collect_1l clearfix">
	  <div class="col-sm-6 space_all">
	   <div class="collect_1ll clearfix">
	    <h5 class="mgt col_1">Sarees</h5>
		<h4>Indian saree collection at best price</h4>
		<h5><a href="product.php"> DISCOVER NOW</a></h5>
	   </div>
	  </div>
	  <div class="col-sm-6 space_all">
	   <div class="collect_1lr clearfix">
	    <img src="img/HOME - vasahindia.jpg" alt="abc" class="iw">
	   </div>
	  </div>
	 </div>
	</div>
	<div class="col-sm-4">
	 <div class="collect_1l clearfix">
	  <div class="col-sm-6 space_all">
	   <div class="collect_1ll clearfix">
	    <h5 class="mgt col_1">Gifts</h5>
		<h4>Discounts Up To 30% </h4>
		<h5><a href="product.php"> DISCOVER NOW</a></h5>
	   </div>
	  </div>
	  <div class="col-sm-6 space_all">
	   <div class="collect_1lr clearfix">
	    <img src="img/still-life-soccer-fan-birthday-theme-party.jpg" alt="abc" class="iw">
	   </div>
	  </div>
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="product_list">
 <div class="container">
  <div class="row">
   <div class="product_list text-center clearfix">
     <div class="col-sm-12">
	  <h3 class="mgt">Trending Items</h3>
	  <hr>
	 </div> 
   </div>
   <div class="gallery_1 clearfix">
    <div class="col-sm-12">
      <div class="workout_page_1_left clearfix">

	    <ul class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" href="#home">MEN  </a></li>
			  <li class=""><a data-toggle="tab" href="#menu1">WOMAN </a></li>
			  <li><a data-toggle="tab" href="#menu2">GIFTS</a></li>
			  <li class=""><a data-toggle="tab" href="#menu3">HANDCRAFTS </a></li>
			  <li class=""><a data-toggle="tab" href="#menu4">KIDS </a></li>
			  
          </ul>

	    <div class="tab-content clearfix">
			  <div id="home" class="tab-pane fade  clearfix active in">
				 <div class="click clearfix">
					<div class="home_inner clearfix">
					<?php foreach ($mens as $men): ?>
							<div class="col-sm-3">
								<div class="workout_1_inner clearfix">
									<div class="workout_1_in1 clearfix">
										<a href="#"><img id="categoryimg" src="<?= htmlspecialchars($men['image_path']) ?>" class="iw" alt="<?= htmlspecialchars($item['item_name']) ?>"></a>
										<h5><a href="#"><?= htmlspecialchars($men['item_name']) ?></a></h5>
										<h5>Rs.<?= htmlspecialchars($men['price']) ?></h5>
									</div>
									<div class="workout_1_in2 clearfix">
										<div class="col-sm-6 space_all">
											<h6 class="mgt"><a href="#">ADD TO CART</a></h6>
										</div>
										<div class="col-sm-6 space_all">
											<ul class="mgt pull-right">
												<li><a href="#"><i class="fa fa-eye"></i></a></li>
												<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
												<li><a href="#"><i class="fa fa-bar-chart-o"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="workout_1_in3 clearfix">
										<h6 class="mgt bg">NEW</h6>
									</div>
								</div>
							</div>
					<?php endforeach; ?>
					</div>
			   </div>
			  </div>
			  <div id="menu1" class="tab-pane fade   clearfix">
				 <div class="click clearfix">
				    <div class="home_inner clearfix">
					<?php foreach ($sarees as $saree): ?>
						<div class="col-sm-3">
							<div class="workout_1_inner clearfix">
								<div class="workout_1_in1 clearfix">
									<a href="#"><img id="categoryimg" src="<?= htmlspecialchars($saree['image_path']) ?>" class="iw" alt="<?= htmlspecialchars($item['item_name']) ?>"></a>
									<h5><a href="#"><?= htmlspecialchars($saree['item_name']) ?></a></h5>
									<h5>Rs.<?= htmlspecialchars($saree['price']) ?></h5>
								</div>
								<div class="workout_1_in2 clearfix">
									<div class="col-sm-6 space_all">
										<h6 class="mgt"><a href="#">ADD TO CART</a></h6>
									</div>
									<div class="col-sm-6 space_all">
										<ul class="mgt pull-right">
											<li><a href="#"><i class="fa fa-eye"></i></a></li>
											<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
											<li><a href="#"><i class="fa fa-bar-chart-o"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="workout_1_in3 clearfix">
									<h6 class="mgt bg">NEW</h6>
								</div>
							</div>
						</div>
            		<?php endforeach; ?>
					</div>
			   </div>
			  </div>
			  <div id="menu2" class="tab-pane fade  clearfix ">
				 <div class="click clearfix">
					<div class="home_inner clearfix">
					<?php foreach ($gifts as $gift): ?>
						<div class="col-sm-3">
							<div class="workout_1_inner clearfix">
								<div class="workout_1_in1 clearfix">
									<a href="#"><img id="categoryimg" src="<?= htmlspecialchars($gift['image_path']) ?>" class="iw" alt="<?= htmlspecialchars($item['item_name']) ?>"></a>
									<h5><a href="#"><?= htmlspecialchars($gift['item_name']) ?></a></h5>
									<h5>Rs.<?= htmlspecialchars($gift['price']) ?></h5>
								</div>
								<div class="workout_1_in2 clearfix">
									<div class="col-sm-6 space_all">
										<h6 class="mgt"><a href="#">ADD TO CART</a></h6>
									</div>
									<div class="col-sm-6 space_all">
										<ul class="mgt pull-right">
											<li><a href="#"><i class="fa fa-eye"></i></a></li>
											<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
											<li><a href="#"><i class="fa fa-bar-chart-o"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="workout_1_in3 clearfix">
									<h6 class="mgt bg">NEW</h6>
								</div>
							</div>
						</div>
           		 	<?php endforeach; ?>
					</div>
			   </div>
			  </div>
			  <div id="menu3" class="tab-pane fade  clearfix ">
				 <div class="click clearfix">
					<div class="home_inner clearfix">
					<?php foreach ($handcrafts as $hand): ?>
						<div class="col-sm-3">
							<div class="workout_1_inner clearfix">
								<div class="workout_1_in1 clearfix">
									<a href="#"><img id="categoryimg" src="<?= htmlspecialchars($hand['image_path']) ?>" class="iw" alt="<?= htmlspecialchars($item['item_name']) ?>"></a>
									<h5><a href="#"><?= htmlspecialchars($hand['item_name']) ?></a></h5>
									<h5>Rs.<?= htmlspecialchars($hand['price']) ?></h5>
								</div>
								<div class="workout_1_in2 clearfix">
									<div class="col-sm-6 space_all">
										<h6 class="mgt"><a href="#">ADD TO CART</a></h6>
									</div>
									<div class="col-sm-6 space_all">
										<ul class="mgt pull-right">
											<li><a href="#"><i class="fa fa-eye"></i></a></li>
											<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
											<li><a href="#"><i class="fa fa-bar-chart-o"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="workout_1_in3 clearfix">
									<h6 class="mgt bg">NEW</h6>
								</div>
							</div>
						</div>
            		<?php endforeach; ?>
					</div>
			   </div>
			  </div>
			  <div id="menu4" class="tab-pane fade  clearfix ">
				 <div class="click clearfix">
					<div class="home_inner clearfix">
					<?php foreach ($kids as $kid): ?>
						<div class="col-sm-3">
							<div class="workout_1_inner clearfix">
								<div class="workout_1_in1 clearfix">
									<a href="#"><img id="categoryimg" src="<?= htmlspecialchars($kid['image_path']) ?>" class="iw" alt="<?= htmlspecialchars($item['item_name']) ?>"></a>
									<h5><a href="#"><?= htmlspecialchars($kid['item_name']) ?></a></h5>
									<h5>Rs.<?= htmlspecialchars($kid['price']) ?></h5>
								</div>
								<div class="workout_1_in2 clearfix">
									<div class="col-sm-6 space_all">
										<h6 class="mgt"><a href="#">ADD TO CART</a></h6>
									</div>
									<div class="col-sm-6 space_all">
										<ul class="mgt pull-right">
											<li><a href="#"><i class="fa fa-eye"></i></a></li>
											<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
											<li><a href="#"><i class="fa fa-bar-chart-o"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="workout_1_in3 clearfix">
									<h6 class="mgt bg">NEW</h6>
								</div>
							</div>
						</div>
            		<?php endforeach; ?>
					</div>
			   </div>
			  </div>
			</div>
		</div>
	</div>
   </div>
  </div>
 </div>
</section>

<section id="trending">
 <div class="container">
  <div class="row">
   <div class="trending_1 mgt clearfix">
    <div class="col-sm-4">
	 <div class="trending_1i1 clearfix">
	  <div class="col-sm-12">
       <h4 class="mgt">On Sale</h4>
	   <hr>
	  </div>
	 </div>
	 
	</div>
	<div class="col-sm-4">
	 <div class="trending_1i1 clearfix">
	  <div class="col-sm-12">
       <h4 class="mgt">Just Arrived</h4>
	   <hr>
	  </div>
	 </div>
	 
	</div>
	<div class="col-sm-4">
	 <div class="trending_1i1 clearfix">
	  <div class="col-sm-12">
       <h4 class="mgt">Top Picks for you</h4>
	   <hr>
	  </div>
	 </div>
	
	</div>
   </div>


   <div class="row">
    <!-- On Sale Section -->
    <div class="col-sm-4">
        
        <?php while ($row = $sale->fetch_assoc()) { ?>
            <div class="trending_1i clearfix">
                <div class="col-sm-5 space_left">
                    <div class="trending_1il clearfix">
                        <div class="trending_1il1 clearfix">
                            <img src="<?php echo $row['image_path']; ?>" class="iw" alt="<?php echo $row['item_name']; ?>">
                        </div>
                        <div class="trending_1il2 text-center clearfix">
                            <span><a href="#"><i class="fa fa-shopping-bag"></i></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 space_right">
                    <div class="trending_1ir clearfix">
                        <h5 class="mgt"><a href="#"><?php echo $row['item_name']; ?></a></h5>
                        <h6>Rs.<?php echo $row['price']; ?></h6>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Just Arrived Section -->
    <div class="col-sm-4">
        
        <?php while ($row = $arrive->fetch_assoc()) { ?>
            <div class="trending_1i clearfix">
                <div class="col-sm-5 space_left">
                    <div class="trending_1il clearfix">
                        <div class="trending_1il1 clearfix">
                            <img src="<?php echo $row['image_path']; ?>" class="iw" alt="<?php echo $row['item_name']; ?>">
                        </div>
                        <div class="trending_1il2 text-center clearfix">
                            <span><a href="#"><i class="fa fa-shopping-bag"></i></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 space_right">
                    <div class="trending_1ir clearfix">
                        <h5 class="mgt"><a href="#"><?php echo $row['item_name']; ?></a></h5>
                        <h6>Rs.<?php echo $row['price']; ?></h6>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Top Picks for You Section -->
    <div class="col-sm-4">
       
        <?php while ($row = $top->fetch_assoc()) { ?>
            <div class="trending_1i clearfix">
                <div class="col-sm-5 space_left">
                    <div class="trending_1il clearfix">
                        <div class="trending_1il1 clearfix">
                            <img src="<?php echo $row['image_path']; ?>" class="iw" alt="<?php echo $row['item_name']; ?>">
                        </div>
                        <div class="trending_1il2 text-center clearfix">
                            <span><a href="#"><i class="fa fa-shopping-bag"></i></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 space_right">
                    <div class="trending_1ir clearfix">
                        <h5 class="mgt"><a href="#"><?php echo $row['item_name']; ?></a></h5>
                        <h6>Rs.<?php echo $row['price']; ?></h6>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</section>	



<section id="shipping">
 <div class="container">
  <div class="row">
   <div class="shipping_1 clearfix">
    <div class="col-sm-3">
	 <div class="shipping_1i clearfix">
	  <span><i class="fa fa-rocket"></i></span>
	  <h5 class="mgt">FREE SHIPING <br> <span class="col_2">Orders over Rs.3000</span></h5>
	 </div>
	</div>
	<div class="col-sm-3">
	 <div class="shipping_1i clearfix">
	  <span><i class="fa fa-recycle"></i></span>
	  <h5 class="mgt">FREE RETURN <br> <span class="col_2">Within 30 days returns</span></h5>
	 </div>
	</div>
	<div class="col-sm-3">
	 <div class="shipping_1i clearfix">
	  <span><i class="fa fa-lock"></i></span>
	  <h5 class="mgt">SUCURE PAYMENT <br> <span class="col_2">100% safe transactions</span></h5>
	 </div>
	</div>
	<div class="col-sm-3">
	 <div class="shipping_1i clearfix">
	  <span><i class="fa fa-tags"></i></span>
	  <h5 class="mgt">BEST PRODUCTS <br> <span class="col_2">Guaranteed quality</span></h5>
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>

<form method="POST" action="newsletter.php">
<section id="enquiry">
 <div class="container">
  <div class="row">
    <div class="enquiry_1 text-center clearfix">
	 <div class="col-sm-12">
	  <h4 class="mgt">NEWSLETTER</h4>
	  <p>Subscribe to our newsletter and get details about our promotions and events</p>
	  <div class="input-group">
		<input type="text" name="newsletter" class="form-control form_2" placeholder="Your Email">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary" type="button">
				SUBSCRIBE</button>
		</span>
      </div>
	 </div>
	</div>
  </div>
 </div>
</section>
</form>

<?php include 'visitor-footer.php'; ?>


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
</script>
</body>
<script>
    function fetchNotifications() {
        fetch('fetch_notifications.php')
            .then(response => response.json())
            .then(data => {
                const notificationList = document.getElementById('notification-list');
                const notificationDot = document.getElementById('notification-dot');
                notificationList.innerHTML = ''; 
                if (data.notifications.length > 0) {
                    notificationDot.style.display = 'inline'; 

                    data.notifications.forEach(notification => {
                        const notificationItem = document.createElement('div');
                        notificationItem.textContent = notification.message;
                        notificationList.appendChild(notificationItem);
                    });
                } else {
                    notificationDot.style.display = 'none'; // Hide red dot if no new notifications
                }
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Fetch notifications on page load
    document.addEventListener('DOMContentLoaded', fetchNotifications);

    // Optionally, set an interval to refresh notifications dynamically
    setInterval(fetchNotifications, 5000); // Fetch every 5 seconds
</script>
</html>
