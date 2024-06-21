<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login_style.css">

     <!-- Icon for the Title of the website -->
     <link rel="icon" href="Images/Logo - Copy.jpg" />

    <!-- CND Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Login</title>
</head>
<body>
    <section class="container_login">
        <div class="box form-box">
            <?php
            include("config.php");

            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $result = mysqli_query($con, "SELECT * FROM customers WHERE email='$email'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if ($row && password_verify($password, $row['password'])) {
                    $_SESSION['valid'] = $row['email'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['surname'] = $row['surname'];

                    // Redirect only if the login is successful
                    header("Location: menu_order.php");
                    exit;
                } else {
                    echo "<div class='message'>
                            <p>Wrong email or password.</p>
                          </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn btn-primary'>Go Back</button></a>"; 
                }
            } else {
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="form-group"> 
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" autocomplete="off" id="email" required>
                </div>

                <div class="form-group"> 
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" autocomplete="off" id="password" required>
                </div>

                <div class="form-group"> 
                    <input type="submit" class="btn btn-primary" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Don't have an account? <a href="register.php">Register Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
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
