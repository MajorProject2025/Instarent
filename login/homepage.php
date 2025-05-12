<?php
session_start();
include("db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instarent - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #9b0050;
            --secondary: #EDDD5E;
            --light: #F7F7F7;
            --dark: #404A3D;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:linear-gradient(to right,#9b0050,#0200d6);
        }
        
        .welcome-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 3rem;
            margin-top: 5rem;
            max-width: 800px;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .welcome-heading {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
        }
        
        .welcome-text {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
        }
        
        .action-btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            margin: 0.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        
        .primary-btn {
            border:2px solid #eddd5e;
            background:#9b0050;
            color:white;
        }
        .primary-btn:hover{
            background:#eddd5e;
            color:black;
            border:2px solid #9b0050;
        }
        .secondary-btn {
            border:2px solid #eddd5e;
            background:#9b0050;
            color:white;
        }
        .secondary-btn:hover{
            background:#eddd5e;
            color:black;
            border:2px solid #9b0050;
        }
        
        .logout-btn {
            background-color: #e74a3b;
            color: white;
            border: 2px solid #e74a3b;
        }
        
        .logout-btn:hover {
            background-color: #be2617;
            border-color: #be2617;
            color: white;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .user-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center welcome-container">
                <div class="user-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h1 class="welcome-heading">
                    Welcome, <?php echo htmlspecialchars($_SESSION['firstName']) . ' ' . htmlspecialchars($_SESSION['lastName']); ?>!
                </h1>
                <p class="welcome-text">
                    Manage your rental products or browse items available in our marketplace.
                </p>
                <div class="d-flex flex-wrap justify-content-center">
                    <a href="list product\my_products.php" class="action-btn primary-btn">
                        <i class="fas fa-box-open me-2"></i>View My Products
                    </a>
                    <a href="list product\list_product.html" class="action-btn secondary-btn">
                        <i class="fas fa-plus-circle me-2"></i>List New Product
                    </a>
                    <a href="../index.html" class="action-btn secondary-btn">
                        <i class="fas fa-home me-2"></i>Go to Homepage
                    </a>
                    <a href="logout.php" class="action-btn logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add any JavaScript functionality here if needed
    </script>
</body>
</html>