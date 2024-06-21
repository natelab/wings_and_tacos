<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link to the CSS File -->
    <link rel="stylesheet" href="login_style.css">

    <!-- Icon for the Title of the website -->
    <link rel="icon" href="Images/Logo - Copy.jpg" />

    <!-- CND Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Link to Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Oswald:wght@200..700&family=Spicy+Rice&display=swap" rel="stylesheet">
    
    <title>Register</title>
    <style>
        .toggle-password {
            cursor: pointer;
            margin-left: -30px;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container_register">
        <div class="box form-box">
            <?php
            include("config.php");
            $registration_successful = false;
            $email_already_used = false;
            $password_error = "";
            $password_mismatch = false;
            $email_error = false;

            $name = $surname = $email = $contact_num = $address = "";

            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $contact_num = $_POST['contact_num'];
                $address = $_POST['address'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                if (strpos($email, '@') === false || substr($email, -4) !== '.com') {
                    $email_error = true;
                }

                if(strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password)) {
                    $password_error = "Password must be at least 8 characters long, include one uppercase letter, one special character, and one number.";
                } elseif($password !== $confirm_password) {
                    $password_mismatch = true;
                } elseif(!$email_error) {
                    $verify_query = mysqli_query($con, "SELECT Email FROM customers WHERE Email='$email'");

                    if(mysqli_num_rows($verify_query) != 0) {
                        $email_already_used = true;
                    } else {
                        // Hash the password before storing it
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                        mysqli_query($con, "INSERT INTO customers(name, surname, email, contact_num, address, password) VALUES('$name', '$surname', '$email', '$contact_num', '$address', '$hashed_password')") or die("Error Occurred");

                        $registration_successful = true;
                    }
                }
            }

            if ($registration_successful) {
                echo "<div class='message'>
                        <p>Registration Successful!</p>
                      </div> <br>";
                echo "<a href='login.php'><button class='btn btn-primary'>Login Now</button></a>";
            } elseif ($email_already_used) {
                echo "<div class='message'>
                        <p>This email has already been used, Please try another one.</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn btn-secondary'>Go Back</button></a>"; 
            } else {
            ?>
            <header>Sign Up</header>
            <form action="" method="post">
                <div class="form-group field input"> 
                    <label for="name">Name</label>
                    <input type="text" name="name" autocomplete="off" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <div class="form-group field input"> 
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" autocomplete="off" id="surname" class="form-control" value="<?php echo htmlspecialchars($surname); ?>" required>
                </div>

                <div class="form-group field input"> 
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                    <?php if ($email_error): ?>
                        <div class="error">Invalid email format. Email must contain '@' and end with '.com'.</div>
                    <?php endif; ?>
                </div>

                <div class="form-group field input"> 
                    <label for="contact_num">Contact Number</label>
                    <input type="text" name="contact_num" autocomplete="off" id="contact_num" class="form-control" value="<?php echo htmlspecialchars($contact_num); ?>" required>
                </div>

                <div class="form-group field input"> 
                    <label for="address">Full Address</label>
                    <input type="text" name="address" autocomplete="off" id="address" class="form-control" value="<?php echo htmlspecialchars($address); ?>" required>
                </div>

                <div class="form-group field input"> 
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" autocomplete="off" id="password" class="form-control" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">Show</span>
                    </div>
                    <?php if (!empty($password_error)): ?>
                        <div class="error"><?php echo $password_error; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group field input"> 
                    <label for="confirm_password">Confirm Password</label>
                    <div style="position: relative;">
                        <input type="password" name="confirm_password" autocomplete="off" id="confirm_password" class="form-control" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">Show</span>
                    </div>
                    <?php if ($password_mismatch): ?>
                        <div class="error">Passwords do not match.</div>
                    <?php endif; ?>
                </div>

                <div class="field"> 
                    <input type="submit" class="btn btn-primary submit" name="submit" value="Register" required>
                </div>

                <div class="links">
                    Already have an account? <a href="login.php">Sign In</a>
                </div>

                <div class="links">
                    <a href="main.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
            <?php 
            } 
            ?>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const toggle = field.nextElementSibling;
            if (field.type === 'password') {
                field.type = 'text';
                toggle.textContent = 'Hide';
            } else {
                field.type = 'password';
                toggle.textContent = 'Show';
            }
        }
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

<footer class="footer">
    <div class="container" >
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
