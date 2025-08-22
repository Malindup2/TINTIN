<!DOCTYPE html>
<?php 
/**
 * Product Detail Page
 * Displays detailed information about a specific product
 */

session_start();
require 'conn.php';

// Get product ID from URL parameter
if(isset($_GET['id'])){
	$id = $_GET['id'];
}
else{
	header("Location: product.php");
}

// Include appropriate header based on login status
if(isset($_SESSION['user_id'])){
	include "home-header.php";
}
else{
	include "visitor-header.php";
}

// Get product details from database
$sql = "SELECT * from items where id = '$id'";
$result = $conn -> query($sql);
$row = $result->fetch_assoc();

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop On</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/detail.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
	<style>.rating {
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
  margin-bottom: 15px;
}

.rating input {
  display: none;
}

.rating label {
  font-size: 2rem;
  color: #ddd;
  cursor: pointer;
  margin-left: 5px;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
  color: #ffc107; 
}
.rating_display {
    display: flex;
    margin-top: 5px;
}

.star {
    font-size: 1.5rem;
    color: #ddd;
    margin-right: 2px;
}

.star.filled {
    color: #ffc107; 
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
	   <a href="#">Product Detail</a>
	  </h5>
	 </div>
	</div>
  </div>
 </div>
</section>

<section id="product" class="clearfix">
 <div class="container">
  <div class="row" style="padding-left:300px">
    <div class="product_1 clearfix">
	 
	  
	 </div>
	 <div class="col-sm-9">
	  <div class="center_detail_2 clearfix">
	    <div class="col-sm-5">
		 <div class="center_detail_2_left clearfix">
		   <div class="carousel slide article-slide" id="article-photo-carousel">

		  <div class="carousel-inner cont-slider">
		
			<div class="item active">
			  <div class="mag">
                <div class="magnify"><div class="magnify"><img data-toggle="magnify" src="<?php echo $row['image_path'] ?>" alt=""><div class="magnify-large" style="background: url(&quot;img/53.jpg&quot;) no-repeat;"></div></div><div class="magnify-large"></div></div>
            </div>
			</div>
		  </div>
		  
        </div>
		 </div>
		</div>
		<div class="col-sm-7">
		 <div class="center_detail_2_right clearfix">
		  <div class="center_detail_2_right_inner clearfix">
		    <h3> <?php echo $row['item_name'] ?></h3>
			<h4>
			<?php 
				 $num = "SELECT COUNT(id) AS total_reviews FROM item_review WHERE item_id = '$id'";
				 $result = $conn->query($num);
			 
				 if ($result) {
					 $nums = $result->fetch_assoc();
				 } else {
					 $nums['total_reviews'] = 0; 
				 }
			 ?>
			 <a href="#">(<?php echo $nums['total_reviews']; ?>) user reviews</a>
			
			
			<h5><span>Tags:</span> <a href="#"><?php echo $row['category'] ?></a></a></h5>
			<h2><?php echo $row['price'] ?></h2>
			<p><?php echo $row['description'] ?></p>
			
			
			<h5 class="heading_1"  data-id="<?php echo $row['id']; ?>"><a href="#">WISHLIST</a></h5>
		  </div>
		  <div class="center_detail_2_right_inner_1 clearfix">
		    <ul>
			 <li><a href="#"><i class="fa fa-heart"></i> Add To Cart</a></li>
             
			</ul>
		  </div>
		  
		 </div>
		</div>
	   </div>
	   <div class="center_detail_2 clearfix">
    <div class="center_detail_2_right_inner_2 clearfix">
        <ul class="nav nav-tabs">
            <li ><a data-toggle="tab" href="#home_description">Reviews</a></li>
            <li><a data-toggle="tab" href="#menu_review">Comments </a></li>
        </ul>

        <div class="tab-content clearfix">
    <!-- Reviews Tab -->
	<div id="home_description" class="tab-pane fade show active">
    <?php 
        $rev = "SELECT * FROM item_review WHERE item_id = '$id'";
        $result = $conn->query($rev);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="click clearfix">
                    <div class="col-sm-11 space_left">
                        <div class="click_inner_2_right clearfix">
                            <h5>
                                <span><?php echo htmlspecialchars($row['name']); ?></span> – <?php echo htmlspecialchars($row['date']); ?>
                            </h5>
                            <h5><?php echo htmlspecialchars($row['messege']); ?></h5>
                            <div class="rating_display">
                                <?php 
                                    $rating = (int)$row['rating']; 
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="star filled">★</span>';
                                        } else {
                                            echo '<span class="star">★</span>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No reviews available for this item.</p>";
        }
    ?>
</div>



    <!-- Comments Tab -->
    <div id="menu_review" class="tab-pane fade">
        <div class="click clearfix">
            <div class="click_inner_3 clearfix">
                <h4>Add your thoughts</h4>
                <p>What do you think about this item?</p>
                
                <form method="POST" id="review" action="add_review.php">
    <h5>Your Name *</h5>
    <input name="name" type="text" class="form-control" required>

    <h5>Your Email *</h5>
    <input name="email" type="email" class="form-control" required>
    
    <h5>Your Comment *</h5>
    <textarea name="messege" class="form-control form_1" required></textarea>
    
    <h5>Your Rating *</h5>
    <div class="rating">
        <input type="radio" id="star5" name="rating" value="5" required>
        <label for="star5" title="5 stars">★</label>
        <input type="radio" id="star4" name="rating" value="4">
        <label for="star4" title="4 stars">★</label>
        <input type="radio" id="star3" name="rating" value="3">
        <label for="star3" title="3 stars">★</label>
        <input type="radio" id="star2" name="rating" value="2">
        <label for="star2" title="2 stars">★</label>
        <input type="radio" id="star1" name="rating" value="1">
        <label for="star1" title="1 star">★</label>
    </div>
<style>

</style>
    <h6><button type="submit" name="review" class="button">SUBMIT</button></h6>
    <input name="id" type="hidden" value="<?php echo $id ?>" class="form-control" required>
</form>

            </div>
        </div>
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
<section id="product_list">
    <?php 
        $qitems = "SELECT * FROM items ORDER BY RAND() LIMIT 4";
        $items = $conn->query($qitems);
        
        if ($items && $items->num_rows > 0) {
            $data = $items->fetch_all(MYSQLI_ASSOC); 
        } else {
            $data = []; 
        }
    ?>
    <div class="container">
        <div class="row">
            <div class="related clearfix">
                <div class="col-sm-12">
                    <h2 class="mgt">Related Products</h2>
                </div>
            </div>
            <div class="home_inner clearfix">
                <?php foreach ($data as $row) { ?>
                    <div class="col-sm-3">
                        <div class="workout_1_inner clearfix">
                            <div class="workout_1_in1 clearfix">
                                <a href="product_detail.php?id=<?php echo $row['id']; ?>"><img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="iw" alt="Product Image"></a>
                                <h5><a href="#"><?php echo htmlspecialchars($row['item_name']); ?></a></h5>
                                <h5><?php echo htmlspecialchars($row['price']); ?></h5>
                            </div> 
                            <div class="workout_1_in2 clearfix">
                                <div class="col-sm-6 space_all">
                                    <h6 class="mgt"><a href="#" class=".fa fa-heart" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['item_name']; ?>" data-price="<?php echo $row['price']; ?>" data-image="<?php echo $row['image_path']; ?>">ADD TO CART</a></h6>
                                </div>
                                <div class="col-sm-6 space_all">
                                    <ul class="mgt pull-right">
                                        <li><a  href="product_detail.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#" class="heading_1" data-id="<?php echo $row['id']; ?>" ><i class="fa fa-heart-o"></i></a></li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="workout_1_in3 clearfix">
                                <h6 class="mgt bg">NEW</h6>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (empty($data)) { ?>
                    <div class="col-sm-12">
                        <p>No products available.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php include 'visitor-footer.php' ?>
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

<script type="text/javascript">
	/*
Credits:
https://github.com/marcaube/bootstrap-magnify
*/


!function ($) {

    "use strict"; // jshint ;_;


    /* MAGNIFY PUBLIC CLASS DEFINITION
     * =============================== */

    var Magnify = function (element, options) {
        this.init('magnify', element, options)
    }

    Magnify.prototype = {

        constructor: Magnify

        , init: function (type, element, options) {
            var event = 'mousemove'
                , eventOut = 'mouseleave';

            this.type = type
            this.$element = $(element)
            this.options = this.getOptions(options)
            this.nativeWidth = 0
            this.nativeHeight = 0

            this.$element.wrap('<div class="magnify" \>');
            this.$element.parent('.magnify').append('<div class="magnify-large" \>');
            this.$element.siblings(".magnify-large").css("background","url('" + this.$element.attr("src") + "') no-repeat");

            this.$element.parent('.magnify').on(event + '.' + this.type, $.proxy(this.check, this));
            this.$element.parent('.magnify').on(eventOut + '.' + this.type, $.proxy(this.check, this));
        }

        , getOptions: function (options) {
            options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

            if (options.delay && typeof options.delay == 'number') {
                options.delay = {
                    show: options.delay
                    , hide: options.delay
                }
            }

            return options
        }

        , check: function (e) {
            var container = $(e.currentTarget);
            var self = container.children('img');
            var mag = container.children(".magnify-large");

            // Get the native dimensions of the image
            if(!this.nativeWidth && !this.nativeHeight) {
                var image = new Image();
                image.src = self.attr("src");

                this.nativeWidth = image.width;
                this.nativeHeight = image.height;

            } else {

                var magnifyOffset = container.offset();
                var mx = e.pageX - magnifyOffset.left;
                var my = e.pageY - magnifyOffset.top;

                if (mx < container.width() && my < container.height() && mx > 0 && my > 0) {
                    mag.fadeIn(100);
                } else {
                    mag.fadeOut(100);
                }

                if(mag.is(":visible"))
                {
                    var rx = Math.round(mx/container.width()*this.nativeWidth - mag.width()/2)*-1;
                    var ry = Math.round(my/container.height()*this.nativeHeight - mag.height()/2)*-1;
                    var bgp = rx + "px " + ry + "px";

                    var px = mx - mag.width()/2;
                    var py = my - mag.height()/2;

                    mag.css({left: px, top: py, backgroundPosition: bgp});
                }
            }

        }
    }


    /* MAGNIFY PLUGIN DEFINITION
     * ========================= */

    $.fn.magnify = function ( option ) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('magnify')
                , options = typeof option == 'object' && option
            if (!data) $this.data('tooltip', (data = new Magnify(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.magnify.Constructor = Magnify

    $.fn.magnify.defaults = {
        delay: 0
    }


    /* MAGNIFY DATA-API
     * ================ */

    $(window).on('load', function () {
        $('[data-toggle="magnify"]').each(function () {
            var $mag = $(this);
            $mag.magnify()
        })
    })

} ( window.jQuery );
	</script>
	
<script type="text/javascript">
	$(document).on('click', '.number-spinner button', function () {    
	var btn = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 1;
		}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
});


document.querySelectorAll('.fa fa-heart').forEach(button => {
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
    // When the heart icon is clicked
    $('.heading_1').click(function (e) {
      e.preventDefault(); // Prevent default action of the link

      const itemId = $(this).data('id'); // Get the item ID

      // Make an AJAX request to store the item ID in the wishlist
      $.ajax({
        url: 'add_to_wishlist.php', // PHP file to handle the request
        method: 'POST',
        data: { id: itemId },
        success: function (response) {
          alert(response); // Optional: Alert the server's response
        },
        error: function (xhr, status, error) {
          console.error('Error:', error); // Log any error
        },
      });
    });
  });
	</script>
</body>
 
</html>
