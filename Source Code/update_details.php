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
    <link rel="stylesheet" href="update_details_style.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <h2>Update Your Details</h2>
            <form action="" method="post">
                <div class="field">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="field">
                    <label for="surname">Surname:</label>
                    <input type="text" name="surname" id="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
                </div>

                <div class="field">
                    <label for="contact_num">Contact Number:</label>
                    <input type="text" name="contact_num" id="contact_num" value="<?php echo htmlspecialchars($user['contact_num']); ?>" required>
                </div>

                <div class="field">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>

                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                </div>

                <div class="field submit">
                    <input type="submit" name="update" value="Update" class="btn">
                </div>
            </form>
        </div>
    </div>
</body>
</html>



