<?php
session_start();

// Calculate total price
$total = 0;
foreach ($_SESSION['cart'] as $product) {
    $total += $product['price'] * $product['quantity'];
}

// Check if the function already exists before declaring it
if (!function_exists('generateSignature')) {
    /**
     * @param array $data
     * @param null $passPhrase
     * @return string
     */
    function generateSignature($data, $passPhrase = null) {
        // Create parameter string
        $pfOutput = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        // Remove last ampersand
        $getString = substr($pfOutput, 0, -1);
        if ($passPhrase !== null) {
            $getString .= '&passphrase=' . urlencode(trim($passPhrase));
        }
        return md5($getString);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Wings & Tacos</title>

    <!-- Icon for the Title of the website -->
    <link rel="icon" href="Images/Logo - Copy.jpg" />

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="menu_order_style.css"/>

    <!-- CDN Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Link to Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Oswald:wght@200..700&family=Spicy+Rice&display=swap" rel="stylesheet">
    
    <style>
        /* Styles for the match the design language */
        body {
            background-color: #fdf9ed; /* Same background color as the menu page */
        }

        .checkout {
            max-width: 800px;
            width: 100%;
            margin: 30px auto;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            padding: 20px;
            border-radius: 20px;
            font-family: 'Oswald', sans-serif;
        }

        .checkout h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .checkout table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .checkout th, .checkout td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .checkout th {
            background-color: #f4f4f4;
            color: #333;
        }

        .checkout td img {
            width: 50px;
            height: auto;
            border-radius: 10px;
        }

        .checkout .total-row {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .btn-payment {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-family: 'Oswald', sans-serif;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-payment:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <section class="checkout">
        <div class="container">
            <div class="receipt-header">
                <img src="Images/checkout logo.png" alt="Wings & Tacos Logo">
                <h2>Checkout Receipt</h2>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $product): ?>
                        <tr>
                            <td><img src="data:image/jpeg;base64,<?php echo $product['image']; ?>" height="50"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>R<?php echo $product['price']; ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td>R<?php echo $product['price'] * $product['quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                        <td><strong>R<?php echo $total; ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <!--<button class="btn-payment">Proceed to Payment</button> -->
            <form action="https://sandbox.payfast.co.za/eng/process" method="post">
                <input type="hidden" name="merchant_id" value="10000100">
                <input type="hidden" name="merchant_key" value="46f0cd694581a">
                <input type="hidden" name="return_url" value="https://www.example.com/success">
                <input type="hidden" name="cancel_url" value="https://www.example.com/cancel">
                <input type="hidden" name="notify_url" value="https://www.example.com/notify">

            <input type="hidden" name="amount" value="<?php echo $total; ?>">
            <input type="hidden" name="item_name" value="Wings & Tacos Order">
            <input type="submit" class="btn-payment" value="Proceed to Payment">
        </form>

        <div class="receipt-footer">
            <p>Thank you for your purchase!</p>
            <p>Wings & Tacos 2024 ©. All rights reserved.</p>
        </div>
    </div>
</section>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="Images/Footer Logo.png" alt="Footer Logo" class="footer-logo">
            </div>
            <div class="col-md-6 text-right">
                <div class="social-links">
                    <p>Connect with us: <br><!-- Added text -->
                        <a href="https://www.tiktok.com/@mamtimande333?lang=en"><i class="fab fa-tiktok fa-lg"></i></a>
                        <a href="https://www.instagram.com/wings_tacos/"><i class="fab fa-instagram fa-lg"></i></a>
                    </p>
                </div>
                <p class="copyright">
                    Wings & Tacos 2024 ©. All rights reserved.
                    <br><br> <!-- Added empty line space -->
                    This Website Was Developed, Designed and Is Maintained by Nathan Tinashe Mazonde
                    <br>
                    <a href="https://www.linkedin.com/in/nathan-mazonde"><i class="fab fa-linkedin fa-lg"></i></a>
                    <a href="https://github.com/natelab"><i class="fab fa-github fa-lg"></i></a>
                </p>
            </div>
        </div>
    </div>
</footer>
</html>
