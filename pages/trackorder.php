<?php
session_start();
include '../includers/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'] ?? null;
$status = null;

if ($order_id) {
    $stmt = $conn->prepare("SELECT status FROM orders WHERE order_id = ? AND user_id = ?");
    $stmt->execute([$order_id, $user_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    $status = $order['status'] ?? null;
}

// Define status steps in order
$status_steps = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
$status_index = array_search($status, $status_steps);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 70%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .status-container {
            margin-top: 20px;
            text-align: center;
        }
        .progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            position: relative;
            padding: 10px 0;
        }
        .progress-bar::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 4px;
            background: #ddd;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            z-index: 0;
        }
        .step {
            position: relative;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            background: #ddd;
            color: white;
            font-size: 14px;
            text-align: center;
            z-index: 1;
            transition: all 0.3s ease;
        }
        .step.active {
            background: #007bff;
        }
        .step.cancelled {
            background: red;
        }
        .status-text {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Track Your Order</h2>
        <form method="GET">
            <input type="text" name="order_id" placeholder="Enter Order ID" required>
            <button type="submit">Track</button>
        </form>

        <?php if ($order_id): ?>
            <?php if ($status): ?>
                <div class="status-container">
                    <h3>Status: <span style="color: <?= ($status == 'Cancelled') ? 'red' : '#007bff' ?>"><?= $status ?></span></h3>
                    
                    <div class="progress-bar">
                        <?php foreach ($status_steps as $index => $step): ?>
                            <div class="step 
                                <?= $index <= $status_index ? 'active' : '' ?>
                                <?= $status == 'Cancelled' ? 'cancelled' : '' ?>">
                                <?= $index + 1 ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="status-text"><?= $status_steps[$status_index] ?? 'Unknown' ?></div>
                </div>
            <?php else: ?>
                <p style="color: red;">Order not found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
