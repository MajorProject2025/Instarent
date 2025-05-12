<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

include("db_connection.php");

// Get cart items with user details
$query = "SELECT ci.*, u.firstName, u.lastName 
          FROM cart_items ci 
          JOIN users u ON ci.email = u.email 
          ORDER BY ci.id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<!-- Query Error: " . mysqli_error($conn) . " -->";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .admin-links {
            display: flex;
            gap: 15px;
        }
        .admin-links a {
            text-decoration: none;
            color: #333;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }
        .admin-links a:hover {
            background-color: #e9ecef;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table {
            width: 100%;
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .no-orders {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2>Admin Dashboard - InstaRent</h2>
            <div class="admin-links">
                <a href="../index.html"><i class="fas fa-home"></i> Homepage</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <div class="table-container">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price per Unit</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['product_name']) ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td>₹<?= number_format($row['price'], 2) ?></td>
                                <td>₹<?= number_format($row['price'] * $row['quantity'], 2) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-orders">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <h4>No Orders Yet</h4>
                    <p>Cart items will appear here when users add products to their cart.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
