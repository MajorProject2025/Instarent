<?php
session_start();
include("db_connection.php"); // Or your DB include

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"]; // Use hashed passwords in production

    $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: homepage.php");
        }
    } else {
        echo "Invalid email or password";
    }
}
?>
