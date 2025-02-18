<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_rental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $conn->real_escape_string($_POST["product_name"]);
    $category = $conn->real_escape_string($_POST["category"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $rental_price = floatval($_POST["rental_price"]);
    
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if($check !== false) {
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }
        
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert into database
            $sql = "INSERT INTO products (product_name, category, description, rental_price, image_path) 
                    VALUES ('$product_name', '$category', '$description', $rental_price, '$target_file')";
            
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