<?php
require "conn.php";


$filters = json_decode(file_get_contents('php://input'), true);
$categories = $filters['categories'] ?? [];
$prices = $filters['prices'] ?? [];

// Build the SQL query dynamically based on filters
$query = "SELECT * FROM items WHERE 1=1";

if (!empty($categories)) {
    $categoriesList = implode("','", array_map('addslashes', $categories));
    $query .= " AND category IN ('$categoriesList')";
}

if (!empty($prices)) {
    $priceConditions = [];
    foreach ($prices as $priceRange) {
        if ($priceRange === "500+") {
            $priceConditions[] = "price > 500";
        } else {
            [$min, $max] = explode('-', $priceRange);
            $priceConditions[] = "price BETWEEN $min AND $max";
        }
    }
    $query .= " AND (" . implode(' OR ', $priceConditions) . ")";
}

$result = $conn->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="col-sm-4">
            <div class="workout_1_inner clearfix">
                <div class="workout_1_in1 clearfix">
                    <a href="detail.html">
                        <div class="image-container">
                            <img src="' . htmlspecialchars($row['image_path']) . '" class="iw" alt="' . htmlspecialchars($row['item_name']) . '">
                        </div>
                    </a>
                    <h5><a href="detail.html">' . htmlspecialchars($row['item_name']) . '</a></h5>
                    <h5>' . htmlspecialchars($row['price']) . '</h5>
                </div>
                <div class="workout_1_in2 clearfix">
                    <div class="col-sm-6 space_all">
                        <h6 class="mgt"><a href="#" class="add-to-cart-btn" data-id="' . htmlspecialchars($row['id']) . '" data-name="' . htmlspecialchars($row['item_name']) . '" data-price="' . htmlspecialchars($row['price']) . '" data-image="' . htmlspecialchars($row['image_path']) . '">ADD TO CART</a></h6>
                    </div>
                    <div class="col-sm-6 space_all">
                        <ul class="mgt pull-right">
                            <li><a href="detail.html"><i class="fa fa-eye"></i></a></li>
                            <li><a href="#" class="wishlist-btn" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-heart-o"></i></a></li>
                            <li><a href="detail.html"><i class="fa fa-bar-chart-o"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="workout_1_in3 clearfix">
                    <h6 class="mgt bg">NEW</h6>
                </div>
            </div>
        </div>';
    }
} else {
    echo "No items found.";
}
?>
