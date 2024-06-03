<?php
//PHP that will allow connection to the data base

$servername = "localhost";
$username = "root";
$password = "";
$dnname = "wings_and_tacos";

$conn= new mysqli($servername, $username, $password, $dnname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

?>