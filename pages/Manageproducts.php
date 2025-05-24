<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

include '../includers/db.php';

// Fetch products with seller names (LEFT JOIN ensures "Unknown" for missing sellers)
$stmt = $conn->query("
    SELECT 
        p.id, 
        p.name, 
        p.price, 
        p.description, 
        p.image, 
        COALESCE(u.username, 'Unknown') AS seller_name
    FROM products p
    LEFT JOIN users u ON p.seller_id = u.id;
");
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
            background-color: #f4f7fa;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        td img {
            width: 50px;
            height: auto;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            padding: 6px 12px;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        .actions .edit {
            background-color: #007bff;
            border: 1px solid #007bff;
        }
        .actions .edit:hover {
            background-color: #0056b3;
        }
        .actions .delete {
            background-color: #dc3545;
            border: 1px solid #dc3545;
        }
        .actions .delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Products</h2>
    <?php if (count($products) > 0) : ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Seller Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= $product['id']; ?></td>
                <td><?= htmlspecialchars($product['name']); ?></td>
                <td>$<?= number_format($product['price'], 2); ?></td>
                <td><?= htmlspecialchars($product['description']); ?></td>
                <td><img src="../images/<?= htmlspecialchars($product['image']); ?>" alt="Product Image"></td>
                <td><?= htmlspecialchars($product['seller_name']); ?></td>
                <td class="actions">
                    <a href="editproduct.php?id=<?= $product['id']; ?>" class="edit">Edit</a>
                    <a href="deleteproduct.php?id=<?= $product['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style="text-align: center; color: red;">No products available.</p>
<?php endif; ?>

    <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
</div>

</body>
</html>
