<?php
session_start();
include '../includers/db.php';

// Check if a seller or admin is logged in
if (!isset($_SESSION['seller_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch products based on user role
if (isset($_SESSION['admin_id'])) {
    // Admin: Fetch all products with seller names
    $stmt = $conn->query("SELECT p.*, u.username AS seller_name FROM products p 
                          LEFT JOIN users u ON p.seller_id = u.id");
} else {
    // Seller: Fetch only their own products
    $seller_id = $_SESSION['seller_id'];
    $stmt = $conn->prepare("SELECT p.*, u.username AS seller_name FROM products p 
                            LEFT JOIN users u ON p.seller_id = u.id
                            WHERE p.seller_id = ?");
    $stmt->execute([$seller_id]);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
           body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .action-buttons a {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }
        .edit-btn {
            background-color: #FFC107;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .edit-btn:hover {
            background-color: #e0a800;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
        }
        /* Your existing CSS styles */
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Products</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Seller Name</th> <!-- Added Seller Name column -->
            <th>Action</th>
        </tr>
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td>$<?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><img src="../images/<?= htmlspecialchars($product['image']); ?>" width="60" alt="Product Image"></td>
                    <td><?= htmlspecialchars($product['seller_name'] ?? 'Unknown') ?></td> <!-- Display Seller Name -->
                    <td>
                        <div class="action-buttons">
                            <?php if (isset($_SESSION['admin_id']) || $product['seller_id'] == $_SESSION['seller_id']): ?>
                                <a href="editproduct.php?id=<?= $product['id'] ?>" class="edit-btn">Edit</a>
                                <a href="deleteproduct.php?id=<?= $product['id'] ?>" class="delete-btn" 
                                   onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            <?php else: ?>
                                <span>N/A</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No products found.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
  





<?php
session_start();
include '../includers/db.php';

// Check if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch products based on user role
if ($user['role'] === 'admin') {
    // Admin: Fetch all products with seller names
    $stmt = $conn->query("SELECT p.*, u.username AS seller_name FROM products p 
                          LEFT JOIN users u ON p.seller_id = u.id");
} else {
    // Seller: Fetch only their own products
    $stmt = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
    $stmt->execute([$user_id]);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
