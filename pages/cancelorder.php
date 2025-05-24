<?php
session_start();
include '../includers/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'] ?? null;
$message = "";
$alertType = "";

if ($order_id) {
    $stmt = $conn->prepare("SELECT status FROM orders WHERE order_id = ? AND user_id = ?");
    $stmt->execute([$order_id, $user_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        if ($order['status'] === 'Pending' || $order['status'] === 'Processing') {
            $stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE order_id = ? AND user_id = ?");
            $stmt->execute([$order_id, $user_id]);
            $message = "✅ Order #{$order_id} has been cancelled successfully.";
            $alertType = "success";
        } elseif ($order['status'] === 'Cancelled') {
            $message = "⚠️ Order #{$order_id} has already been cancelled.";
            $alertType = "warning";
        } else {
            $message = "❌ Order #{$order_id} cannot be cancelled.";
            $alertType = "danger";
        }
    } else {
        $message = "❌ Invalid order ID or you do not have permission to cancel this order.";
        $alertType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($message): ?>
        <div class="alert <?php echo $alertType; ?>">
            <?php echo $message; ?>
        </div>
        <script>
            alert("<?php echo strip_tags($message); ?>");
        </script>
    <?php endif; ?>
    <br>
    <a href="orders.php" class="btn">Back to Orders</a>
</div>

</body>
</html>
