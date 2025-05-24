<?php
session_start();
include '../includers/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Fetch orders for the logged-in user
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
        }
        .order {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #fafafa;
            position: relative;
        }
        .canceled {
            border: 2px solid #dc3545 !important;
            background-color: #ffe6e6 !important;
        }
        .canceled h3, .canceled p {
            color: #dc3545;
            font-weight: bold;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status.Pending { background-color: #ffcc00; color: #333; }
        .status.Processing { background-color: #007bff; color: #fff; }
        .status.Shipped { background-color: #17a2b8; color: #fff; }
        .status.Delivered { background-color: #28a745; color: #fff; }
        .status.Cancelled { background-color: #dc3545; color: #fff; }
        .order-items {
            margin-top: 10px;
            padding-left: 20px;
        }
        .product {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .product img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
            border: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin-top: 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }
        .track-btn { background-color: #007bff; }
        .cancel-btn { background-color: #dc3545; }
        .invoice-btn { background-color: #28a745; }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Orders</h2>

        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order <?= $order['status'] == 'Cancelled' ? 'canceled' : '' ?>">
                    <h3>Order ID: <?= $order['order_id'] ?></h3>
                    <p><strong>Total Price:</strong> ₹<?= number_format($order['total_price'], 2) ?></p>
                    <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
                    <p><strong>Status:</strong> <span class="status <?= $order['status'] ?>"><?= $order['status'] ?></span></p>
                    <p><strong>Placed On:</strong> <?= $order['created_at'] ?></p>

                    <!-- Fetch order items along with seller information -->
                    <?php
                    $stmt = $conn->prepare("SELECT oi.*, p.name AS product_name, p.image, 
                                            u.username AS seller_name 
                                            FROM order_items oi 
                                            JOIN products p ON oi.product_id = p.id 
                                            LEFT JOIN users u ON p.seller_id = u.id 
                                            WHERE oi.order_id = ?");
                    $stmt->execute([$order['order_id']]);
                    $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <div class="order-items">
                        <h4>Products:</h4>
                        <?php foreach ($order_items as $item): ?>
                            <?php 
                                $imagePath = "../images/" . htmlspecialchars($item['image']); 
                                if (!file_exists($imagePath) || empty($item['image'])) {
                                    $imagePath = "../images/default.png"; // Use a default placeholder if missing
                                }
                                $sellerName = !empty($item['seller_name']) ? htmlspecialchars($item['seller_name']) : "Unknown";
                            ?>
                            <div class="product">
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                <div>
                                    <p><strong>Product:</strong> <?= htmlspecialchars($item['product_name']) ?></p>
                                    <p><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
                                    <p><strong>Price:</strong> ₹<?= number_format($item['price'], 2) ?></p>
                                    <p><strong>Sold By:</strong> <?= $sellerName ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Buttons Section -->
                    <a href="trackorder.php?order_id=<?= $order['order_id'] ?>" class="btn track-btn">Track Order</a>
                    
                    <?php if (in_array($order['status'], ['Pending', 'Processing'])): ?>
                        <a href="cancelorder.php?order_id=<?= $order['order_id'] ?>" class="btn cancel-btn" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</a>
                    <?php endif; ?>

                    <a href="generateinvoice.php?order_id=<?= $order['order_id'] ?>" class="btn invoice-btn" target="_blank">Download Invoice</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">No orders placed yet.</p>
        <?php endif; ?>

        <div class="back-link">
            <a href="../landingpage.php">← Back to Home</a>
        </div>
    </div>
</body>
</html>
