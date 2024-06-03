<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

            <?php 
            include("config.php");
            $registration_successful = false; // Flag to track registration success
            $email_already_used = false; // Flag to track email already used

            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $contact_num = $_POST['contact_num'];
                $address = $_POST['address'];
                $password = $_POST['password'];

                // Making sure that the email does not already exist
                $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");

                if(mysqli_num_rows($verify_query) != 0) {
                    $email_already_used = true;
                } else {
                    mysqli_query($con, "INSERT INTO users(name, surname, email, contact_num, address, password) VALUES('$name', '$surname', '$email', '$contact_num', '$address', '$password')") or die("Error Occurred");

                    $registration_successful = true; // Set flag to true upon successful registration
                }
            }

            if ($registration_successful) {
                echo "<div class='message'>
                        <p>Registration Successful!</p>
                      </div> <br>";
                echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
            } elseif ($email_already_used) {
                echo "<div class='message'>
                        <p>This email has already been used, Please try another one.</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>"; 
            } else {
            ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input"> 
                    <label for="name">Name</label>
                    <input type="text" name="name" autocomplete="off" id="name" required>
                </div>

                <div class="field input"> 
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" autocomplete="off" id="surname" required>
                </div>

                <div class="field input"> 
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" id="email" required>
                </div>

                <div class="field input"> 
                    <label for="contact_num">Contact Number</label>
                    <input type="text" name="contact_num" autocomplete="off" id="contact_num" required>
                </div>

                <div class="field input"> 
                    <label for="address">Full Address</label>
                    <input type="text" name="address" autocomplete="off" id="address" required>
                </div>

                <div class="field input"> 
                    <label for="password">Password</label>
                    <input type="password" name="password" autocomplete="off" id="password" required>
                </div>

                <div class="field"> 
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>

                <div class="links">
                    Already have an account? <a href="login.php">Sign In</a>
                </div>
            </form>

            <?php 
            } 
            ?>
        </div>
    </div>
</body>
</html>


