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

    <!--Icon for the Title of the website-->
    <link
    rel="icon"
    href="Images/Logo - Copy.jpg"
    />

    <!--Link to the CSS File-->
    <link rel="stylesheet" href="style.css"/>

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
                <li><a href="#">Home</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact Us</a></li>
                <button onclick="window.location.href='login.php'"><a href="#">Login</a></button>
                <button onclick="window.location.href='register.php'"><a href="#">Register</a></button>
            </ul>
        </div>
        <div class="navicons">
            <a href="https://www.tiktok.com/@mamtimande333?lang=en"><i class="fa-brands fa-tiktok"></i></a>
            <a href="https://www.instagram.com/wings_tacos/"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </nav>
</section>

 
    <section class="moreinfo">
      <!--MORE INFORMATION SECTION-->
      <div class="goodwords">
       <p>LOCALLY MADE MOUTH WATERING
         <br>
         WINGS, TACOS, DRINKS
         <br>
         & COOKIESSSS!!!!!!!
         <br>
         (WHO CAN FORGET THE COOKIES!!!!!)
       </p>
      </div>

      <!--Scroll Indicator-->

      <div class="arrow-scroll">
         <div class="arrow"></div>
         <div class="arrow"></div>
         <div class="arrow"></div>
      </div>
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
            <button onclick="window.location.href='login.php'" class="add">Add to cart</button>
        </div>
        <?php } ?>
    </main>
</section>

</body>
</html>