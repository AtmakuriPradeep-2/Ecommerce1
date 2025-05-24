<?php
session_start();
include '../includers/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    die("Order ID missing.");
}

$order_id = $_GET['order_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Invalid Order ID.");
}

$stmt = $conn->prepare("SELECT oi.*, p.name AS product_name, p.image FROM order_items oi 
                        JOIN products p ON oi.product_id = p.id 
                        WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .invoice-container { width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; background: #fff; }
        h2 { text-align: center; }
        .order-info { margin-bottom: 20px; }
        .order-info p { margin: 5px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .items-table th { background: #f8f8f8; }
        .print-btn { margin-top: 20px; display: flex; justify-content: center; }
        .print-btn button { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="invoice-container">
    <h2>Invoice</h2>
    <div class="order-info">
        <p><strong>Order ID:</strong> <?= $order['order_id'] ?></p>
        <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
        <p><strong>Status:</strong> <?= $order['status'] ?></p>
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
        <p><strong>Total Price:</strong> ₹<?= number_format($order['total_price'], 2) ?></p>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= $item['product_name'] ?></td>
                <td><img src="../images/<?= htmlspecialchars($item['image']) ?>" width="50"></td>
                <td><?= $item['quantity'] ?></td>
                <td>₹<?= number_format($item['price'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="print-btn">
        <button onclick="window.print()">Print Invoice</button>
    </div>
</div>

</body>
</html>
