<!DOCTYPE html>

<?php 
/**
 * Contact Page
 * Provides contact information and contact form for customer inquiries
 */

session_start();

// Include appropriate header based on login status
if(isset($_SESSION['user_id'])){
	include ('home-header.php');
}else{
	include ('visitor-header.php');
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop On</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/contact.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	
  </head>
  
<body>

	
<section id="center" class="center_shop clearfix">
 <div class="container">
  <div class="row">
    <div class="center_shop_1 clearfix">
	 <div class="col-sm-12">
	  <h5 class="mgt">
	   <a href="home.php">Home <i class="fa fa-long-arrow-right"></i> </a>
	   <a href="contact.php">Contact</a>
	  </h5>
	 </div>
	</div>
  </div>
 </div>
</section>
<form method="POST" action="contact_process.php">
<section id="contact" class="clearfix">
 <div class="container">
  <div class="row">
    <div class="contact_1  clearfix">
	 <div class="col-sm-8">
	  <div class="contact_1lm clearfix">
	  <div class="contact_1l clearfix">
	   <h4 class="col_1 mgt">Get in touch</h4>
	   <h3>Write Us A Message</h3>
	  </div><br>
	  <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
	    <h5>Your Name <span class="col_3">*</span></h5>
		<input class="form-control" type="text" name='name' required>
	   </div>
	   <div class="col-sm-6 space_left">
	    <h5>Your Subjects <span class="col_3">*</span></h5>
		<input class="form-control" type="text" name='subject' required>
	   </div>
	  </div>
	  <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
	    <h5>Your Email<span class="col_3">*</span></h5>
		<input class="form-control" type="email" name='email' required>
	   </div>
	   <div class="col-sm-6 space_left">
	    <h5>Your Phone <span class="col_3">*</span></h5>
		<input class="form-control" type="text" pattern="^\+?[0-9]{10,15}$" name='phone' required>
	   </div>
	  </div>
	  <div class="checkout_1l1 clearfix">
	   <div class="col-sm-12 space_left">
	    <h5>Your Message <span class="col_3">*</span></h5>
		<textarea class="form-control form_1" name='message' required></textarea>
		<input class="button" type="submit" value="SEND MESSAGE" >
	   </div>
	  </div>
	 </div>
	 </div>
	 <div class="col-sm-4">
	  <div class="contact_1rm clearfix">
	    <div class="contact_1r1 mgt clearfix">
		 <span><i class="fa fa-phone"></i></span>
		 <h4>Call us Now:</h4>
		
		 <p class="mgt">+94 768606545</p>
		</div>
		<div class="contact_1r1 clearfix">
		 <span><i class="fa fa-phone"></i></span>
		 <h4>Email:</h4>
		 <p><a href="#">info@TINTIN.com</a></p>
		 <p class="mgt">support@TINTIN.com</p>
		</div>
		<div class="contact_1r1 clearfix">
		 <span><i class="fa fa-phone"></i></span>
		 <h4>Our Address:</h4>
		 <p>14/1, TINTIN , Main Street</p>
		 <p class="mgt">Matara , Sri Lanka.</p>
		</div>
	  </div>
	 </div>
	</div>
	<div class="contact_2 clearfix">
	  <div class="col-sm-12">
	  <iframe width="1180" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=1180&amp;height=400&amp;hl=en&amp;q=%20matara+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.acadoo.de/fachrichtungen/ghostwriter-medizin/'>Abschlussarbeit Medizin Unterstützung</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=51ca994a685ebebe1c7ef8a1df6c2f4864f6f569'></script>
	  </div>
	 </div>
  </div>
 </div>
</section>
	   </form>
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
<?php include 'visitor-footer.php' ?>
</body>
 
</html>
