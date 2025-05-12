<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listed Products | Instarent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color:rgb(94, 149, 237);
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-color: #5a5c69;
            --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            padding-top: 2rem;
            background-color: #c9d6ff;
            background:linear-gradient(to right,#9b0050,#0200d6);
        }
        
        .header-container {
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .page-title {
            color: black;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .add-product-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
        }
        
        .add-product-btn:hover {
            background-color: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11);
        }
        
        .product-table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .product-table thead {
            background-color: var(--primary-color);
            color: white;
        }
        
        .product-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }
        
        .product-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        
        .product-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-table tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .product-title {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .product-description {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .product-price {
            font-weight: 700;
            color: #28a745;
        }
        
        .product-category {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            background-color: #e9ecef;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #495057;
        }
        
        .action-btns {
            display: flex;
            gap: 0.5rem;
        }
        
        .action-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .edit-btn {
            background-color: #ffc107;
            color: #212529;
        }
        
        .edit-btn:hover {
            background-color: #e0a800;
            color: #212529;
        }
        
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #c82333;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-container d-flex justify-content-between align-items-center">
            <h1 class="page-title">My Listed Products</h1>
            <a href="list_product.html" class="add-product-btn">
                <i class="fas fa-plus-circle me-2"></i>Add New Product
            </a>
        </div>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($row['image_path']) ?>" 
                                         class="product-image" 
                                         alt="<?= htmlspecialchars($row['title']) ?>">
                                </td>
                                <td>
                                    <div class="product-title"><?= htmlspecialchars($row['title']) ?></div>
                                </td>
                                <td>
                                    <div class="product-description">
                                        <?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...
                                    </div>
                                </td>
                                <td class="product-price">₹<?= number_format($row['price'], 2) ?></td>
                                <td>
                                    <span class="product-category"><?= ucfirst($row['category']) ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state bg-white rounded shadow-sm p-5">
                <i class="fas fa-box-open"></i>
                <h3>No Products Listed Yet</h3>
                <p>You haven't listed any products for rent. Get started by adding your first product!</p>
                <a href="list_product.html" class="add-product-btn mt-3">
                    <i class="fas fa-plus-circle me-2"></i>Add Your First Product
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>