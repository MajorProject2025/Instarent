<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'];

// Get user email
$email_query = "SELECT email FROM users WHERE id = ?";
$stmt = $conn->prepare($email_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$email = $user['email'];

switch ($action) {
    case 'get_cart':
        $query = "SELECT * FROM cart_items WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            echo json_encode(['error' => 'Database error: ' . $conn->error]);
            exit;
        }
        
        $items = [];
        $total = 0;
        
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
            $total += $row['price'] * $row['quantity'];
        }
        
        echo json_encode(['items' => $items, 'total' => $total]);
        break;

    case 'add_to_cart':
        $product_id = $_POST['product_id'] ?? 0;
        $product_name = $_POST['product_name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;
        
        // Check if item already exists in cart
        $check_query = "SELECT * FROM cart_items WHERE email = ? AND product_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("si", $email, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update quantity
            $update_query = "UPDATE cart_items SET quantity = quantity + ? WHERE email = ? AND product_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("isi", $quantity, $email, $product_id);
        } else {
            // Insert new item
            $insert_query = "INSERT INTO cart_items (email, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sisdi", $email, $product_id, $product_name, $price, $quantity);
        }
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to add to cart: ' . $conn->error]);
        }
        break;

    case 'update_quantity':
        $product_id = $_POST['product_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 0;
        
        if ($quantity <= 0) {
            // Remove item
            $delete_query = "DELETE FROM cart_items WHERE email = ? AND product_id = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("si", $email, $product_id);
        } else {
            // Update quantity
            $update_query = "UPDATE cart_items SET quantity = ? WHERE email = ? AND product_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("isi", $quantity, $email, $product_id);
        }
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to update cart: ' . $conn->error]);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?> 