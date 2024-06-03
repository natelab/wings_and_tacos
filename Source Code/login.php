<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php

            include("config.php");
            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
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
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>"; 
                }
            } else {
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input"> 
                    <label for="email">Email</label>
                    <input type="text" name="email" autocomplete="off" id="email" required>
                </div>

                <div class="field input"> 
                    <label for="password">Password</label>
                    <input type="password" name="password" autocomplete="off" id="password" required>
                </div>

                <div class="field"> 
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Don't have an account? <a href="register.php">Register Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>

