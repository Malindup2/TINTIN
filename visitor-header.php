<?php
/**
 * Visitor Header Component
 * Navigation header for non-logged-in users with login/signup options
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
	   
	   
	   <li><i class="fa fa-user col_1"></i> <a href="signup.php"> Register</a></li>
	   <li class="border_none"><i class="fa fa-power-off col_1"></i> <a href="login.php"> Login</a></li>
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
	 <select class="form-control form_1">
	 			 <option name="filter">All categories</option>
				 <option name="filter">Sarees</option>
				 <option name="filter">Men's Fashion</option>
				 <option name="filter">Gifts</option>
				 <option name="filter">Handcrafts</option>
				 <option name="filter">Kids</option>
			 </select>
	  <div class="input-group">
					<input name="search" type="text" class="form-control form_2" placeholder="Search Products Here...">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="submit">
							<i class="fa fa-search"></i></button>
					</span>
      </div>
	 </div>
	</form>
	</div>
	<div class="col-sm-3">
	 <div class="header_1r clearfix">
	  <ul class="nav navbar-nav mgt navbar-right">
				
				<li><a class="tag_m1" href="profile.php"><i class="fa fa-user"></i></a></li>
				
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
			<!-- Brand and toggle get grouped for better mobile display -->
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form method="POST" id="catform" action="product_filter1.php">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="m_tag1" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa fa-bars"></i> CATEGORIES
						</a>
						<ul class="dropdown-menu drop_2" role="menu">
							<!-- Add hidden input and set its value via JavaScript -->
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
					<li><a class="m_tag" href="login.php">Log in</a></li>
				</ul>
				<!-- Hidden input for the selected filter -->
				<input type="hidden" name="filter" id="filterInput">
			</form>

<script>
    // JavaScript function to set the category and submit the form
    function setCategoryAndSubmit(category) {
        document.getElementById('filterInput').value = category;
        document.getElementById('catform').submit();
    }
</script>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>
	
	</section>
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

