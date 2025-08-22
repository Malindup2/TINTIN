<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    /**
     * Payment Failed Page
     * Displays error message when payment processing fails
     */
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .failed-card {
            width: 400px; 
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .failed-header {
            background-color: #FF4C4C; 
            color: white;
            text-align: center;
            padding: 40px 20px;
        }
        .failed-header img {
            width: 80px; 
        }
        .failed-body {
            background-color: white;
            padding: 30px;
            text-align: center;
        }
        .failed-body p {
            margin: 15px 0;
            color: #666;
            font-size: 16px;
        }
        .btn-custom {
            background-color: #FF4C4C;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 25px;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #E04343;
            color: white;
        }
    </style>
</head>
<body>
    <div class="failed-card">
        <div class="failed-header">
            <img src="img/payment_failed.png" alt="Failed Icon">
            <h3 class="mt-3">Payment Failed</h3>
        </div>
        <div class="failed-body">
            <p>Oops! Your payment could not be processed. Please try again.</p>
            <a href="cart.php" class="btn btn-custom">Try Again</a>
        </div>
    </div>
</body>
</html>
