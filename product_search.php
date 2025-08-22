
<html>

<?php 
/**
 * Product Search Results Page
 * Displays search results based on user query
 */

session_start();

// Include appropriate header based on login status
if(isset($_SESSION['user_id'])){
    require "home-header.php";
}else{
    require "visitor-header.php";
} 
?>

</html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop On</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/product.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">

    <style>
#categoryFilterSection {
    margin-bottom: 20px;
}


#categoryTitle {
    font-size: 18px;
    margin-bottom: 10px;
}


.category-filter {
    margin-right: 5px;
}

#filterActions {
    display: inline-flex;
    align-items: center;
    gap: 10px; 
    margin-top: 10px;
}


#applyFilterButton {
    padding: 8px 15px;
    background-color: #f4a460;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#applyFilterButton:hover {
    background-color: #d2691e;
}


#clearFilterIcon {
    font-size: 20px;
    color: #d2691e;
    cursor: pointer;
    font-weight: bold;
    line-height: 1;
    padding: 2px 5px;
    transition: color 0.3s ease;
}

#clearFilterIcon:hover {
    color: red;
}

</style>
  </head>
  
<body>

	
<section id="center" class="center_shop clearfix">
 <div class="container">
  <div class="row">
    <div class="center_shop_1 clearfix">
	 <div class="col-sm-12">
	  <h5 class="mgt">
	   <a href="#">Home <i class="fa fa-long-arrow-right"></i> </a>
	   <a href="#">Product List</a>
	  </h5>
	 </div>
	</div>
  </div>
 </div>
</section>

<section id="product" class="clearfix">
 <div class="container">
  <div class="row">
    <div class="product_1 clearfix">
	 <div class="col-sm-3">
     <form method="POST" action="product_filter2.php">
    <div class="product_1l mgt clearfix" id="categoryFilterSection">
        <h4 class="mgt" id="categoryTitle">Categories</h4>
        <h5><input type="radio" class="category-filter" id="filterMen" name="filter" value="Men"> Men's Fashion</h5>
        <h5><input type="radio" class="category-filter" id="filterSarees" name="filter" value="Sarees"> Sarees</h5>
        <h5><input type="radio" class="category-filter" id="filterKids" name="filter" value="Kids"> Kids</h5>
        <h5><input type="radio" class="category-filter" id="filterGifts" name="filter" value="Gifts"> Gifts</h5>
        <h5><input type="radio" class="category-filter" id="filterHandcrafts" name="filter" value="Handcrafts"> Handcrafts</h5>
        <div id="filterActions" class="filter-actions">
            <button id="applyFilterButton" class="filter-btn" type="submit">Apply Filter</button>
            <a href="product.php" id="clearFilterLink">
                <span id="clearFilterIcon" class="close-icon">&times;</span>
            </a>
        </div>
    </div>
</form>


	 </div>
	 <div class="col-sm-9">
	  <div class="product_1r clearfix">
	         
	  </div>
	  <div class="home_inner clearfix">
    <?php
    require "conn.php";
   $category = $_POST['filter'] ?? ''; 
$search = $_POST['search'] ?? '';   

if (!empty($category) && !empty($search)) {
    
    $qitems = "SELECT * FROM items WHERE category = ? AND item_name LIKE ? ORDER BY RAND()";
    $stmt = $conn->prepare($qitems);
    $searchParam = "%$search%";
    $stmt->bind_param("ss", $category, $searchParam);
} elseif (!empty($category)) {
    
    $qitems = "SELECT * FROM items WHERE category = ? ORDER BY RAND()";
    $stmt = $conn->prepare($qitems);
    $stmt->bind_param("s", $category);
} elseif (!empty($search)) {
  
    $qitems = "SELECT * FROM items WHERE item_name LIKE ? ORDER BY RAND()";
    $stmt = $conn->prepare($qitems);
    $searchParam = "%$search%";
    $stmt->bind_param("s", $searchParam);
} else {
   
    $qitems = "SELECT * FROM items ORDER BY RAND()";
    $stmt = $conn->prepare($qitems);
}
  
$stmt->execute();
$items = $stmt->get_result();


    
    $columns = 3;
    $itemCount = 0;
    $data = $items->fetch_all(MYSQLI_ASSOC);

    $totalItems = count($data);

    
    for ($i = 0; $i < ceil($totalItems / $columns); $i++) {
        echo '<div class="row clearfix">'; 

       
        for ($j = 0; $j < $columns; $j++) {
            
            $index = ($i * $columns) + $j;

            if ($index < $totalItems) {
                $row = $data[$index];
                ?>
                <div class="col-sm-4">
                    <div class="workout_1_inner clearfix">
                        <div class="workout_1_in1 clearfix">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="image-container">
                                    <img src="<?php echo $row['image_path']; ?>" class="iw" alt="<?php echo $row['item_name']; ?>">
                                </div>
                            </a>
                            <h5><a href="product_detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['item_name']; ?></a></h5>
                            <h5><?php echo $row['price']; ?></h5>
                        </div>
                        <div class="workout_1_in2 clearfix">
						<div class="col-sm-6 space_all">
						<h6 class="mgt"><a href="#" class="add-to-cart-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['item_name']; ?>" data-price="<?php echo $row['price']; ?>" data-image="<?php echo $row['image_path']; ?>">ADD TO CART</a></h6>

						</div>
                            <div class="col-sm-6 space_all">
                                <ul class="mgt pull-right">
                                    <li><a href="product_detail.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="#" class="wishlist-btn" data-id="<?php echo $row['id']; ?>"><i class="fa fa-heart-o"></i></a></li>
                                    <li><a href="product_detail.php?id=<?php echo $row['id']; ?>"><i class="fa fa-bar-chart-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="workout_1_in3 clearfix">
                            <h6 class="mgt bg">NEW</h6>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        echo '</div>'; // Close the row
    }
    ?>
</div>

	  
	 </div>
	</div>
  </div>
 </div>
</section>

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



<?php include 'visitor-footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function () {
		const id = this.getAttribute('data-id');
        const itemName = this.getAttribute('data-name');
        const price = this.getAttribute('data-price');
        const imagePath = this.getAttribute('data-image');

        // Send AJAX request to add item to cart
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `item_name=${encodeURIComponent(itemName)}&price=${encodeURIComponent(price)}&image_path=${encodeURIComponent(imagePath)}&id=${encodeURIComponent(id)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Item added to cart!');
                } else {
                    alert('Failed to add item to cart.');
                }
            });
    });
});

$(document).ready(function () {
    $('.wishlist-btn').click(function (e) {
      e.preventDefault(); 

      const itemId = $(this).data('id'); 

      $.ajax({
        url: 'add_to_wishlist.php', 
        method: 'POST',
        data: { id: itemId },
        success: function (response) {
          alert(response); 
        },
        error: function (xhr, status, error) {
          console.error('Error:', error); 
        },
      });
    });
  });
</script>
</body>
 
</html>
