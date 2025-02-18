<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

$sql = "SELECT * FROM products WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listed Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>My Listed Products</h2>
    <a href="list_product.php">Add New Product</a>
    <table border="1">
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><img src="<?= $row['image_path'] ?>" width="100"></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td>$<?= $row['price'] ?>/day</td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['availability'] ?></td>
                <td>
                    <a href="delete_product.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
