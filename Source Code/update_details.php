<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];

$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit;
}

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $update_query = "UPDATE users SET name='$name', surname='$surname', contact_num='$contact_num', address='$address', password='$password' WHERE email='$email'";
    if (mysqli_query($conn, $update_query)) {
        echo "Details updated successfully!";
    } else {
        echo "Error updating details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="update_details_style.css">

    <!-- Icon for the Title of the website -->
    <link rel="icon" href="Images/Logo - Copy.jpg" />
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Update Your Details</h2>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname:</label>
                        <input type="text" name="surname" id="surname" class="form-control" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_num">Contact Number:</label>
                        <input type="text" name="contact_num" id="contact_num" class="form-control" value="<?php echo htmlspecialchars($user['contact_num']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" name="address" id="address" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
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
