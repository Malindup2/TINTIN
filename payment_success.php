<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    /**
     * Payment Success Page
     * Displays confirmation message after successful payment processing
     */
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
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
        .success-card {
            width: 400px; 
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .success-header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 40px 20px; 
        }
        .success-header img {
            width: 80px; 
        }
        .success-body {
            background-color: white;
            padding: 30px; 
            text-align: center;
        }
        .success-body p {
            margin: 15px 0;
            color: #666;
            font-size: 16px;
        }
        .btn-custom {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 25px;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #45a049;
            color: white;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-header">
            <img src="img/payment-success.png" alt="Success Icon">
            <h3 class="mt-3">Success</h3>
        </div>
        <div class="success-body">
            <p>Congratulations, your payment has been successfully processed.</p>
            <a href="product.php" class="btn btn-custom">Continue</a>
        </div>
    </div>
</body>
</html>
