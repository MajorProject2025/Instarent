<?php
include 'db_connection.php'; // Use the common connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from session
    session_start();
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to list a product");
    }
    $user_id = $_SESSION['user_id'];
    
    $title = $conn->real_escape_string($_POST["product_name"]);
    $category = $conn->real_escape_string($_POST["category"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $price = floatval($_POST["rental_price"]);
    
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is an actual image
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if($check !== false) {
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }
        
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Insert into database with user_id
            $sql = "INSERT INTO products (user_id, title, category, description, price, image_path) 
                    VALUES ('$user_id', '$title', '$category', '$description', $price, '$target_file')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Product listed successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}

$conn->close();
?>