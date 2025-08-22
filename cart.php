<!DOCTYPE html>
<html>
<?php 
/**
 * Shopping Cart Page
 * Displays user's shopping cart items and allows cart management
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
	<link href="css/cart.css" rel="stylesheet">
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
	   <a href="#">Home <i class="fa fa-long-arrow-right"></i> </a>
	   <a href="#">Cart</a>
	  </h5>
	 </div>
	</div>
  </div>
 </div>
</section>
<form method="POST"  id="checkoutForm" action="place_order.php">
<section id="cart" class="clearfix">
 <div class="container">
  <div class="row">
    <div class="cart_1 clearfix">
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">PRODUCT</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">NAME</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">UNIT PRICE</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">QUANTITY</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">TOTAL</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col"><i class="fa fa-trash"></i></h4> 
	   </div>
	 </div>
	</div>
	<?php

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<div class="cart-container">
    <?php foreach ($cart_items as $index => $item): ?>
    <div class="cart_2 clearfix" data-index="<?php echo $index; ?>" data-price="<?php echo htmlspecialchars($item['price']); ?>">
        <div class="col-sm-2">
            <div class="cart_2i clearfix">
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" class="iw" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="cart_2i clearfix">
                <h4 class="mgt"><a href="#"><?php echo htmlspecialchars($item['item_name']); ?></a></h4>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="cart_2i clearfix">
                <p class="mgt unit-price">Rs. <?php echo htmlspecialchars($item['price']); ?></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="cart_2i clearfix">
                <div class="input-group number-spinner">
                    <span class="input-group-btn">
                        <a class="btn btn-default btn-decrement" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></a>
                    </span>
                    <input type="text" name="cart_items[<?php echo $index; ?>][quantity]" class="form-control text-center quantity-input" value="1">
                    <span class="input-group-btn">
                        <a class="btn btn-default btn-increment" data-dir="up"><span class="glyphicon glyphicon-plus"></span></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="cart_2i clearfix">
                <p class="mgt total-price">Rs. <?php echo htmlspecialchars($item['price']); ?></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="cart_2i clearfix">
                <p class="mgt"><a href="#" class="btn-remove-item"><i class="fa fa-trash"></i></a></p>
            </div>
        </div>
    </div>
    <input type="hidden" name="cart_items[<?php echo $index; ?>][id]" value="<?php echo htmlspecialchars($item["item_name"]); ?>">
                    
    <?php endforeach; ?>
</div>
   
	
	<div class="cart_3 clearfix">
	 <div class="col-sm-4 space_left">
	  <div class="cart_3i clearfix">
	   <input class="form-control" placeholder="Enter Your Coupon" type="text">
	   <h6 class="mgt"><a class="button mgt" href="#">APPLY</a></h6>
	   <h5><input type="checkbox"> Shipping (+Rs. 500)</h5>
	  </div>
	 </div>
	 <div class="col-sm-4 space_left">
	  <div class="cart_3i clearfix">

	  </div>
	 </div>
	 <div class="col-sm-4 space_left">
	  <div class="cart_3i1 clearfix">
	   <h5>Cart Subtotal <span class="pull-right">Rs.430.00</span></h5>
	   <h5>Shipping <span class="pull-right">Free</span></h5>
	   <h5>You Save <span class="pull-right">Rs.40.00</span></h5>
	   <hr>
	   <h5>You Pay <span class="pull-right">Rs.390.00</span></h5><br>
	   <h6>
       <a class="button" onclick="handleCheckout()">CHECKOUT</a>
    </h6>
	   <h6><a class="button" href="product.php">CONTINUE SHOPPING</a></h6>
	  </div>
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

<script >

document.addEventListener('DOMContentLoaded', () => {
    // Update total price when quantity changes
    const updateTotalPrice = (cartItem) => {
        const unitPrice = parseFloat(cartItem.dataset.price);
        const quantityInput = cartItem.querySelector('.quantity-input');
        const totalPriceElement = cartItem.querySelector('.total-price');
        
        const quantity = parseInt(quantityInput.value, 10) || 1;
        const totalPrice = (unitPrice * quantity).toFixed(2);

        totalPriceElement.textContent = `Rs.${totalPrice}`;
    };

    // Increment or decrement quantity
    document.querySelectorAll('.number-spinner').forEach(spinner => {
        const cartItem = spinner.closest('.cart_2');
        const quantityInput = spinner.querySelector('.quantity-input');
        const incrementButton = spinner.querySelector('.btn-increment');
        const decrementButton = spinner.querySelector('.btn-decrement');

        incrementButton.addEventListener('click', () => {
            let quantity = parseInt(quantityInput.value, 10) || 1;
            quantity++;
            quantityInput.value = quantity;
            updateTotalPrice(cartItem);
            updateTotals();
        });

        decrementButton.addEventListener('click', () => {
            let quantity = parseInt(quantityInput.value, 10) || 1;
            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;
                updateTotalPrice(cartItem);
                updateTotals();
            }
        });

        quantityInput.addEventListener('input', () => {
            updateTotalPrice(cartItem);
            updateTotals();
        });

        
    });

    // Remove item from cart
    document.querySelectorAll('.btn-remove-item').forEach(removeButton => {
        removeButton.addEventListener('click', function (e) {
            e.preventDefault();
            
            const cartItem = this.closest('.cart_2');
            const itemIndex = cartItem.dataset.index; // Get the item's index from the data attribute

            // Send AJAX request to remove the item
            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `item_index=${encodeURIComponent(itemIndex)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        cartItem.remove(); // Remove item from DOM
                        updateTotals();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                
        });
        
    });

    // Calculate and update totals
    const couponInput = document.querySelector(".cart_3i input.form-control");
    const applyCouponButton = document.querySelector(".cart_3i a.button");
    const shippingCheckbox = document.querySelector(".cart_3i input[type='checkbox']");
    const cartSubtotalElement = document.querySelector(".cart_3i1 h5:nth-child(1) span");
    const shippingElement = document.querySelector(".cart_3i1 h5:nth-child(2) span");
    const discountElement = document.querySelector(".cart_3i1 h5:nth-child(3) span");
    const totalPayElement = document.querySelector(".cart_3i1 h5:nth-child(5) span");
    const cartItems = document.querySelectorAll(".cart_2");

    let discount = 0;
    let shippingCost = 0;

    const calculateCartSubtotal = () => {
        let subtotal = 0;

        cartItems.forEach((item) => {
            const quantityInput = item.querySelector(".quantity-input");
            const unitPrice = parseFloat(item.getAttribute("data-price"));
            const quantity = parseInt(quantityInput.value, 10);

            subtotal += unitPrice * quantity;
        });

        return subtotal;
    };

    const updateTotals = () => {
        const cartSubtotal = calculateCartSubtotal();
        const totalPay = cartSubtotal + shippingCost - discount;

        cartSubtotalElement.textContent = `Rs. ${cartSubtotal.toFixed(2)}`;
        shippingElement.textContent = shippingCost > 0 ? `Rs. ${shippingCost.toFixed(2)}` : "Free";
        discountElement.textContent = `Rs. ${discount.toFixed(2)}`;
        totalPayElement.textContent = `Rs. ${totalPay.toFixed(2)}`;

        

    };

    // Apply coupon
    applyCouponButton.addEventListener("click", (e) => {
        e.preventDefault();
        const couponCode = couponInput.value.trim();

        if (couponCode) {
            fetch(`apply_coupon.php?code=${couponCode}`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.valid) {
                        discount = parseFloat(data.discount);
                        alert(`Coupon applied! You saved $${discount.toFixed(2)}.`);
                    } else {
                        discount = 0;
                        alert("Invalid coupon code.");
                    }
                    updateTotals();
                })
                .catch((error) => console.error("Error:", error));
        } else {
            alert("Please enter a coupon code.");
        }
    });

    // Handle shipping checkbox
    shippingCheckbox.addEventListener("change", () => {
        shippingCost = shippingCheckbox.checked ? 500 : 0;
        updateTotals();
    });

    // Initialize totals
    updateTotals();
});

function incrementQuantity(index) {
    const quantityInput = document.getElementById(`quantity-${index}`);
    quantityInput.value = parseInt(quantityInput.value) + 1 || 1;
}

function decrementQuantity(index) {
    const quantityInput = document.getElementById(`quantity-${index}`);
    const currentValue = parseInt(quantityInput.value) || 1;
    quantityInput.value = currentValue > 1 ? currentValue - 1 : 1;
}

function handleCheckout() {
    const totalPayElement = document.querySelector(".cart_3i1 h5:nth-child(5) span");
    const billPrice = totalPayElement.textContent.trim();

    // Send the value to the server via AJAX
    fetch("set_session.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ bill_price: billPrice }),
    })
        .then((response) => response.text())
        .then((data) => {
            
            // Redirect to another page after successful checkout
            window.location.href = "checkout.php";
        })
        .catch((error) => {
            console.error("Error:", error);
        });
        document.getElementById('checkoutForm').submit();
    // Prevent the default form submission behavior
    return false;
}
	</script>
</body>
 
</html>
