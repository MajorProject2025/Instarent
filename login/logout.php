<?php
session_start();
include 'db_connection.php';

// Close database connection
$conn->close();

// Destroy session
session_destroy();

// Redirect to login page
header("location: index.php");
?>