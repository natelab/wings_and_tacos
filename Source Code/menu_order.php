<?php
session_start();
require_once 'connection.php';

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $quantity = 1;

    $product_exists = false;

    // Check if the product already exists in the cart
    foreach ($_SESSION['cart'] as $id => $product) {
        if ($product['name'] == $product_name) {
            $product_exists = true;
            $_SESSION['cart'][$id]['quantity']++;
            break;
        }
    }

    // If the product does not exist, add it to the cart
    if (!$product_exists) {
        $_SESSION['cart'][] = array(
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => $quantity
        );
    }
}

// Handle removing from cart
if (isset($_POST['remove'])) {
    $product_name = $_POST['product_name'];
    foreach ($_SESSION['cart'] as $id => $product) {
        if ($product['name'] == $product_name) {
            unset($_SESSION['cart'][$id]);
            break;
        }
    }
}

// Handle updating cart
if (isset($_POST['update'])) {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    foreach ($_SESSION['cart'] as $id => $product) {
        if ($product['name'] == $product_name) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
            break;
        }
    }
}

// Calculate total price and grand total
$total = 0;
foreach ($_SESSION['cart'] as $product) {
    $total += $product['price'] * $product['quantity'];
}


// Handle clearing cart
if (isset($_POST['clear'])) {
    unset($_SESSION['cart']);
}

$spl = "SELECT * FROM products";
$all_product = $conn->query($spl);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wings & Tacos</title>

    <!--Icon for the Title of the website-->
    <link rel="icon" href="Images/Logo - Copy.jpg" />

    <!--Link to the CSS File-->
    <link rel="stylesheet" href="menu_order_style.css"/>

    <!--CND Link to Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Link to Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Oswald:wght@200..700&family=Spicy+Rice&display=swap" rel="stylesheet">
</head>
<body>
    <!--NAVIGATION BAR-->
    <section class="navbar-section">
        <nav class="navbar">
            <a href="main.php"><img src="Images/Taskbar Logo.jpg" height="130"></a>
            <div class="navitems">
                <ul>
                    <button onclick="window.location.href='main.php'"><a href="#">Log Out</a></button>
                    <button onclick="window.location.href='update_details.php'" class="btn">Update Details</button>
                </ul>
            </div>

            <div class="iconCart">
                <img src="Images/cart_icon.png" alt="Cart Image" height="58">
                <!--<div class="totalQuantity">0</div> -->
            </div>
        </nav>
    </section>

    <section class="menu">
        <main class="main">
            <?php while($row = mysqli_fetch_assoc($all_product)) { ?>
            <div class="card">
                <div class="image">
                    <a href="main.php"><img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" height="200"></a>
                </div>
                <div class="caption">
                    <p class="product_name"><?php echo $row["prod_name"]; ?></p>
                    <p class="price"><b>R<?php echo $row["price"]; ?></b></p>
                </div>
                <form method="post" action="">
                    <!--<input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">-->
                    <input type="hidden" name="product_name" value="<?php echo $row['prod_name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo base64_encode($row['img']); ?>">
                    <button type="submit" name="add_to_cart" class="add">Add to cart</button>
                </form>
            </div>
            <?php } ?>
        </main>
    </section>

    <section class="cart">
        <h2>Shopping Cart</h2>
        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                        <?php $total = 0; ?>
                        <?php foreach($_SESSION['cart'] as $id => $product): ?>
                            <tr>
                                <td><img src="data:image/jpeg;base64,<?php echo $product['image']; ?>" height="50"></td>
                                <td><?php echo $product['name']; ?></td>
                                <td>R<?php echo $product['price']; ?></td>
                                <td>
                                <form method="post" action="">
                                <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                <button type="submit" name="update" class="update">Update</button>
                                </form>
                                </td>
                                <td>R<?php echo $product['price'] * $product['quantity']; ?></td>
                                <td>
                                    <button type="submit" name="remove" class="remove">Remove</button>
                                </td>
                            </tr>
                            <?php $total += $product['price'] * $product['quantity']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4">Grand Total</td>
                            <td>R<?php echo $total; ?></td>
                            <td>
                                <button type="submit" name="clear" class="clear">Delete All</button>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Your cart is empty</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <button type="submit" formaction="checkout.php" class="checkout">Proceed To Checkout</button>
        </form>
    </section>

    
</body>
</html>