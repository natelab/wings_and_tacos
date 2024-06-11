<?php

require_once 'connection.php';

$spl = "SELECT * FROM products";
$all_product = $conn->query($spl);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wings & Tacos</title>

    <!-- Icon for the Title of the website -->
    <link rel="icon" href="Images/Logo - Copy.jpg" />

    <!-- Link to the CSS File -->
    <link rel="stylesheet" href="style.css"/>

    <!-- CND Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Link to Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Oswald:wght@200..700&family=Spicy+Rice&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- NAVIGATION BAR -->
<section class="navbar-section">
    <nav class="navbar navbar-expand-lg fixed-top"> <!-- Removed 'navbar-light bg-light' -->
        <a class="navbar-brand" href="main.php"><img src="Images/Taskbar Logo.jpg" height="130"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="color: rgba(50, 50, 52, 255);"><i class="fa fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
            </ul>
            <button onclick="window.location.href='login.php'" class="btn btn-outline-primary ml-2">Login</button>
            <button onclick="window.location.href='register.php'" class="btn btn-outline-primary ml-2">Register</button>
            <div class="navicons ml-3">
                <a href="https://www.tiktok.com/@mamtimande333?lang=en" class="mr-2"><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://www.instagram.com/wings_tacos/"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </nav>
</section>

    <section class="moreinfo">
        <!-- MORE INFORMATION SECTION -->
        <div class="goodwords text-center">
            <p>LOCALLY MADE MOUTH WATERING<br>
            WINGS, TACOS, DRINKS<br>
            & COOKIESSSS!!!!!!!<br>
            (WHO CAN FORGET THE COOKIES!!!!!)
            </p>
        </div>

        <!-- Scroll Indicator -->
        <div class="arrow-scroll">
            <div class="arrow"></div>
            <div class="arrow"></div>
            <div class="arrow"></div>
        </div>
    </section>

    <section class="menu">
    <div class="container">
        <div class="row">
            <?php while($row = mysqli_fetch_assoc($all_product)) { ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="image">
                        <a href="main.php"><img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" class="card-img-top" alt="<?php echo $row["prod_name"]; ?>"></a>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $row["prod_name"]; ?></h5>
                        <p class="card-text"><strong>R<?php echo $row["price"]; ?></strong></p>
                        <button onclick="window.location.href='login.php'" class="btn btn-primary add">Add to cart</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>