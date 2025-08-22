<?php 
/**
 * Checkout Page
 * Handles the checkout process for placing orders
 */

// Start session and check if user is logged in
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit();
}

require 'conn.php';
include 'home-header.php';

// Redirect if bill price isn't set
if(!isset($_SESSION['bill_price'])){
    header("location: product.php");
}
?><!DOCTYPE html>
<html lang="en">
  <head>
        <!-- Basic meta tags and external resources -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop On</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/checkout.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	<script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  
<body>

	
<section id="center" class="center_shop clearfix">
 <div class="container">
  <div class="row">
    <div class="center_shop_1 clearfix">
	 <div class="col-sm-12">
	  <h5 class="mgt">
	   <a href="#">Home <i class="fa fa-long-arrow-right"></i> </a>
	   <a href="#">Checkout</a>
	  </h5>
	 </div>
	</div>
  </div>
 </div>
</section>
<form method="POST" id="checkoutForm" action="billing_process.php">
    <section id="checkout" class="clearfix">
        <div class="container">
            <div class="row">
                <div class="checkout_1 clearfix">
                    <div class="col-sm-8">
                        <h3>Make Your Checkout Here</h3>
                        <p>Please register in order to checkout more quickly</p>
                        <div class="checkout_1l1 clearfix">
                            <div class="col-sm-6">
                                <h5>First Name <span class="col_3">*</span></h5>
                                <input name="firstname" class="form-control" pattern="[A-Za-z\s]+" type="text" required>
                            </div>
                            <div class="col-sm-6">
                                <h5>Last Name <span class="col_3">*</span></h5>
                                <input name="lastname" class="form-control" pattern="[A-Za-z\s]+" type="text" required>
                            </div>
                        </div>
                        <div class="checkout_1l1 clearfix">
                            <div class="col-sm-6">
                                <h5>Email Address <span class="col_3">*</span></h5>
                                <input name="email" class="form-control" type="email" placeholder="e.g. example@mail.com" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"  required>
                            </div>
                            <div class="col-sm-6">
                                <h5>Phone Number <span class="col_3">*</span></h5>
                                <input name="phone" class="form-control" pattern="0[0-9]{9}" type="text" required>
                            </div>
                        </div>
                        <div class="checkout_1l1 clearfix">
                            <div class="col-sm-6">
                                <h5>Province <span class="col_3">*</span></h5>
                                <select name="province" class="form-control" required>
                                    <option value="">-- Select a Province --</option>
                                    <option value="Central">Central</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="North Central">North Central</option>
                                    <option value="Northern">Northern</option>
                                    <option value="North Western">North Western</option>
                                    <option value="Sabaragamuwa">Sabaragamuwa</option>
                                    <option value="Southern">Southern</option>
                                    <option value="Uva">Uva</option>
                                    <option value="Western">Western</option>
                                </select>
                            </div>
                        </div>
                        <div class="checkout_1l1 clearfix">
                            <div class="col-sm-6">
                                <h5>Address Line 1 <span class="col_3">*</span></h5>
                                <input name="address1" class="form-control" type="text" required>
                            </div>
                            <div class="col-sm-6">
                                <h5>Address Line 2</h5>
                                <input name="address2" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="checkout_1l1 clearfix">
                            <div class="col-sm-6">
                                <h5>Postal Code <span class="col_3">*</span></h5>
                                <input name="zip" class="form-control" pattern="[0-9]+" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkout_1r clearfix">
                            <h4 class="mgt">CART TOTALS</h4>
                            <hr class="hr_1">
                            <h5>Sub Total <span class="pull-right"><?php echo 'Rs.' . $_SESSION['bill_price']; ?></span></h5>
                            <hr>
                            <h4>PAYMENTS</h4>
                            <hr class="hr_1">
                            <p>
                                <input name="pmethod" value="Direct Payment" type="radio" required> <span>Direct Payment</span>
                            </p>
                            <p>
                                <input name="pmethod" value="Cash On Delivery" type="radio"> <span>Cash On Delivery</span>
                            </p>
                            <p>
                                <input name="pmethod" value="Bank Transfer" type="radio"> <span>Bank Transfer</span>
                            </p>
                            <br>
                            <button type="submit" class="button">PROCEED TO CHECKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<section id="enquiry">
 <div class="container">
  <div class="row">
    <div class="enquiry_1 text-center clearfix">
	 <div class="col-sm-12">
	  <h4 class="mgt">NEWSLETTER</h4>
	  <p>Subscribe to our newsletter and get <span class="col_1">20%</span> off your first purchase</p>
	  <div class="input-group">
		<input type="text" class="form-control form_2" placeholder="Your Email">
		<span class="input-group-btn">
			<button class="btn btn-primary" type="button">
				SUBSCRIBE</button>
		</span>
      </div>
	 </div>
	</div>
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
	  <h5 class="mgt">FREE SHIPING <br> <span class="col_2">Orders over $100</span></h5>
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
	  <h5 class="mgt">SUCURE PAYMENT <br> <span class="col_2">100% secure payment</span></h5>
	 </div>
	</div>
	<div class="col-sm-3">
	 <div class="shipping_1i clearfix">
	  <span><i class="fa fa-tags"></i></span>
	  <h5 class="mgt">BEST PEICE <br> <span class="col_2">Guaranteed price</span></h5>
	 </div>
	</div>
   </div>
  </div>
 </div>
</section>
<?php include 'visitor-footer.php'?>
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
 
</html>
