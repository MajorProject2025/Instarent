<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "login"; 

// Create connection
$conn = mysqli_connect($servername, $email, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
