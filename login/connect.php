<?php
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's a login attempt
    if (isset($_POST['signIn'])) {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]); // In production, use password_verify() with hashed passwords
        
        // Check user credentials
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: homepage.php");
            }
            exit();
        } else {
            // Login failed - set error message
            $_SESSION['login_error'] = "Invalid email or password";
            header("Location: index.php"); // Redirect back to login page
            exit();
        }
    }
}
?>