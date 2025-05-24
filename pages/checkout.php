<?php
session_start();
include '../includers/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from the database (including product image)
$stmt = $conn->prepare("SELECT cart.*, products.name, products.price, products.image FROM cart 
                        JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    echo "<script>alert('Your cart is empty!'); window.location.href = 'cart.php';</script>";
    exit();
}

$total_price = array_reduce($cart_items, function($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0);

$orderPlaced = false; // Track order status

// Handle order placement
if (isset($_POST['place_order'])) {
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, address, payment_method, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->execute([$user_id, $total_price, $address, $payment_method]);

    $order_id = $conn->lastInsertId();

    // Insert each cart item into order_items table
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
    }

    // Clear cart after order placement
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);

    $orderPlaced = true; // Set flag for JS handling
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
        }

        .checkout-container {
            max-width: 500px;
            background: white;
            margin: 50px auto;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .product-list {
            list-style: none;
            padding: 0;
        }

        .product-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .product-item img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            margin-right: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .product-details {
            flex: 1;
        }

        .total-price {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #ff6600;
            margin-top: 10px;
        }

        .form-container {
            margin-top: 20px;
        }

        textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background: #ff6600;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        button:hover {
            background: #e65c00;
        }

        /* Order Success Popup */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .popup h2 {
            color: #28a745;
            font-size: 24px;
        }

        .popup button {
            background: #007bff;
        }
        .floating-wishes {
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
    }
        

        /* Fade In Effect */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <h3>Order Summary</h3>
        <ul class="product-list">
            <?php foreach ($cart_items as $item): ?>
                <li class="product-item">
                    <img src="../images/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                    <div class="product-details">
                        <p><strong><?= htmlspecialchars($item['name']); ?></strong></p>
                        <p>Quantity: <?= $item['quantity']; ?> x ₹<?= number_format($item['price'], 2); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="total-price">Total: ₹<?= number_format($total_price, 2); ?></p>

        <<div class="form-container">
    <form method="POST">
        <label for="address">Shipping Address:</label>
        <textarea name="address" required></textarea>

        <label for="phone">Contact Number:</label>
        <input type="tel" name="phone" required pattern="[0-9]{10}" 
               placeholder="Enter 10-digit phone number" 
               style="width: 100%; height: 50px; font-size: 18px; padding: 10px;">

        <label for="payment_method">Payment Method:</label>
                <select name="payment_method" required>
                    <option value="COD">Cash on Delivery</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                </select>

                <button type="submit" name="place_order">Place Order</button>
            </form>
        </div>
    </div>
   
<!-- Order Success Popup -->
<div id="orderPopup" class="popup">
    <div class="popup-content">
        <!-- Confetti Effect -->
        <canvas id="confettiCanvas"></canvas>
       
        
        <!-- Floating Balloons -->
                <!-- Sparkling Heading -->
        <h2 class="glow-text">🎉 Order Placed Successfully! 🎉</h2>

        <!-- Celebration GIF -->
        <img src="../images/success.gif" alt="Success Animation">



    

        <!-- Success Message -->
        <p>Thank you for your purchase! Your order is being processed. 🎁</p>
            <span class="wish">🎊 Hurray! 🎊</span>
            <span class="wish">🥳 Order Placed! 🥳</span>
            <span class="wish">🎁 Enjoy Your Purchase! 🎁</span>
            <span class="wish">💖 Thank You! 💖</span>
        <p class="redirect-text">You will be redirected shortly...</p>

        <!-- Sparkling Badge -->
        <img src="../images/success1.png" alt="Success Badge" class="success-badge">

        <!-- Celebration Button -->
        <button onclick="redirectToOrders()">🎊 View My Orders 🎊</button>
    </div>
</div>

<style>
    /* Order Popup */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        text-align: center;
        z-index: 1000;
        animation: fadeIn 0.5s ease-in-out;
        overflow: hidden;
    }

    /* Glowing Text */
    .glow-text {
        color: #ff6600;
        font-size: 28px;
        font-weight: bold;
        text-shadow: 0 0 10px #ff6600, 0 0 20px #ff3300;
        animation: glow 1.5s infinite alternate;
    }

    /* Success Badge Bounce */
    .success-badge {
        width: 80px;
        animation: bounce 1.5s infinite;
    }

    /* Floating Balloons */
    .balloons {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        z-index: -1;
    }

    .balloon {
        width: 50px;
        position: absolute;
        animation: floatUp 5s ease-in-out infinite;
    }

    .balloon:nth-child(1) { left: 20%; animation-duration: 6s; }
    .balloon:nth-child(2) { left: 50%; animation-duration: 7s; }
    .balloon:nth-child(3) { left: 80%; animation-duration: 5s; }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes glow {
        from { text-shadow: 0 0 10px #ff6600, 0 0 20px #ff3300; }
        to { text-shadow: 0 0 15px #ff3300, 0 0 25px #ff0000; }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @keyframes floatUp {
        0% { transform: translateY(100vh); opacity: 1; }
        100% { transform: translateY(-50vh); opacity: 0; }
    }

    /* Confetti Effect */
    canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    /* Pulsing Button */
    .popup button {
        background: linear-gradient(45deg, #ff6600, #ff3300);
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 12px 25px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
        animation: pulse 1.5s infinite;
    }

    .popup button:hover {
        background: linear-gradient(45deg, #e65c00, #ff2200);
    }
    

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }




    /* Sparkle Animation */
@keyframes sparkle {
    0% { opacity: 0; transform: scale(0.5); }
    50% { opacity: 1; transform: scale(1.2); }
    100% { opacity: 0; transform: scale(0.5); }
}

/* Sparkles Container */
.sparkle-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 9999;
}

/* Individual Sparkle */
.sparkle {
    position: absolute;
    width: 10px;
    height: 10px;
    background: radial-gradient(circle, #ffcc00, rgba(255, 204, 0, 0.6), transparent);
    border-radius: 50%;
    box-shadow: 0 0 10px #ffcc00;
    animation: sparkle 1.5s infinite;
}

</style>




    <script>
      document.addEventListener("DOMContentLoaded", function () {
    let orderPlaced = <?= $orderPlaced ? 'true' : 'false'; ?>;

    if (orderPlaced) {
        document.getElementById('orderPopup').style.display = 'block';
        createSparkles(90); // Generate sparkles
        
        setTimeout(() => { 
            window.location.href = 'orders.php'; 
        }, 5000);
    }

    function createSparkles(count) {
        let sparkleContainer = document.createElement("div");
        sparkleContainer.classList.add("sparkle-container");
        document.body.appendChild(sparkleContainer);

        for (let i = 0; i < count; i++) {
            let sparkle = document.createElement("div");
            sparkle.classList.add("sparkle");

            // Random position on the page
            let x = Math.random() * window.innerWidth;
            let y = Math.random() * window.innerHeight;

            sparkle.style.left = `${x}px`;
            sparkle.style.top = `${y}px`;
            sparkle.style.animationDuration = `${1 + Math.random()}s`;
            sparkle.style.animationDelay = `${Math.random()}s`;

            sparkleContainer.appendChild(sparkle);

            // Remove sparkle after animation ends
            setTimeout(() => {
                sparkle.remove();
            }, 2000);
        }
    }
});

    </script>
</body>
</html>
