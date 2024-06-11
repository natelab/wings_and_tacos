<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css">
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
    <div class="container">
        <div class="box form-box">

        <?php
include("config.php");
$registration_successful = false; // Flag to track registration success
$email_already_used = false; // Flag to track email already used
$password_error = ""; // Error message for password issues
$password_mismatch = false; // Flag to track password mismatch
$email_domain_error = false; // Flag to track invalid email domain

$name = $surname = $email = $contact_num = $address = ""; // Initialize variables to retain input values

// List of valid email domains
$valid_domains = array("example.com", "example.org", "example.net");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $contact_num = $_POST['contact_num'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email domain
    $email_parts = explode("@", $email);
    $domain = array_pop($email_parts);
    if (!in_array($domain, $valid_domains)) {
        $email_domain_error = true;
    }

    // Password validation
    if(strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password)) {
        $password_error = "Password must be at least 8 characters long, include one uppercase letter, one special character, and one number.";
    } elseif($password !== $confirm_password) {
        $password_mismatch = true;
    } elseif(!$email_domain_error) {
        // Making sure that the email does not already exist
        $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");

        if(mysqli_num_rows($verify_query) != 0) {
            $email_already_used = true;
        } else {
            mysqli_query($con, "INSERT INTO users(name, surname, email, contact_num, address, password) VALUES('$name', '$surname', '$email', '$contact_num', '$address', '$password')") or die("Error Occurred");

            $registration_successful = true; // Set flag to true upon successful registration
        }
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
        <input type="text" name="name" autocomplete="off" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
    </div>

    <div class="field input"> 
        <label for="surname">Surname</label>
        <input type="text" name="surname" autocomplete="off" id="surname" value="<?php echo htmlspecialchars($surname); ?>" required>
    </div>

    <div class="field input"> 
        <label for="email">Email</label>
        <input type="email" name="email" autocomplete="off" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php if ($email_domain_error): ?>
            <div class="error">Invalid email domain.</div>
        <?php endif; ?>
    </div>

    <div class="field input"> 
        <label for="contact_num">Contact Number</label>
        <input type="text" name="contact_num" autocomplete="off" id="contact_num" value="<?php echo htmlspecialchars($contact_num); ?>" required>
    </div>

    <div class="field input"> 
        <label for="address">Full Address</label>
        <input type="text" name="address" autocomplete="off" id="address" value="<?php echo htmlspecialchars($address); ?>" required>
    </div>

    <div class="field input"> 
        <label for="password">Password</label>
        <div style="position: relative;">
            <input type="password" name="password" autocomplete="off" id="password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('password')">Show</span>
        </div>
        <?php if (!empty($password_error)): ?>
            <div class="error"><?php echo $password_error; ?></div>
        <?php endif; ?>
    </div>

    <div class="field input"> 
        <label for="confirm_password">Confirm Password</label>
        <div style="position: relative;">
            <input type="password" name="confirm_password" autocomplete="off" id="confirm_password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">Show</span>
        </div>
        <?php if ($password_mismatch): ?>
            <div class="error">Passwords do not match.</div>
        <?php endif; ?>
    </div>

    <div class="field"> 
        <input type="submit" class="btn" name="submit" value="Register" required>
    </div>

    <div class="links">
        Already have an account? <a href="login.php">Sign In</a>
    </div>

    <div class="links">
    <a href="main.php" class="btn">Back</a>
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


</body>
</html>
