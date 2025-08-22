<!DOCTYPE html>
<?php 
/**
 * About Us Page
 * Information about the company, mission, and team
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
    <title>About Us</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: 'Amaranth', sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 50px 15%;
            text-align: center;
            background-color: #fff;
            color: #333;
        }
        .content h1 {
            font-size: 36px;
            color: #ff6600;
        }
        .content p {
            line-height: 1.8;
            font-size: 18px;
            margin-top: 20px;
            color: #444; 
            font-family: 'Alata', sans-serif; 
        }
        .features {
            display: flex;
            justify-content: space-around;
            padding: 30px 10%;
            background-color: #fdf6f0;
        }
        .feature-item {
            text-align: center;
            max-width: 250px;
        }
        .feature-item img {
            width: 80px;
            margin-bottom: 15px;
        }
        .feature-item h3 {
            font-size: 18px;
            color: #333;
        }
        .feature-item p {
            font-size: 16px;
            color: #666;
            font-family: 'Alata', sans-serif; 
            margin-top: 10px;
        }
        .footer {
            background-color: #222;
            color: #fff;
            padding: 20px 10%;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>About Us</h1>
    </div>

    <div class="content">
        
        <p>
            At TINTIN, we believe that fashion is a form of self-expression, and everyone deserves to feel confident in their own style. 
            From basics to bold designs, we strive to provide the perfect fit for every individual.
        </p>
        <p>
            Since our establishment, TINTIN has been committed to offering the best shopping experience to our customers with quality products, affordable pricing, 
            and excellent customer service. 
        </p>
    </div>

   
</body>
<?php 
include "visitor-footer.php";
?>
</html>
