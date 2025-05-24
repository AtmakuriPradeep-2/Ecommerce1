<?php
// Start session only if it's not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includers/db.php'; // Database connection

// Fetch products using PDO
try {
    $stmt = $conn->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function searchProducts() {
            let input = document.getElementById('searchBar').value.toLowerCase();
            let products = document.getElementsByClassName('product');

            for (let product of products) {
                let name = product.getElementsByTagName('h3')[0].innerText.toLowerCase();
                product.style.display = name.includes(input) ? '' : 'none';
            }
        }
    </script>
    <style>
        /* Styles */
        .search-container {
            text-align: center;
            margin: 20px 0;
        }
        .search-bar {
            width: 60%;
            padding: 12px;
            font-size: 18px;
            border: 2px solid #ddd;
            border-radius: 25px;
            outline: none;
        }
        .search-button {
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 25px;
            background-color: #ff9800;
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-button:hover {
            background-color: #e68900;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: none;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            height: 100px;
            width: 120px;
            margin-right: 15px;
        }
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        .chatbot-header {
            background: #ff9800;
            padding: 10px;
            color: white;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .chatbot-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }
        .chatbot-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .chatbot-input input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }
        .chatbot-input button {
            margin-left: 10px;
            padding: 8px 12px;
            background: #ff9800;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #ff9800;
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo-container">
                <img src="images/Megamart.jpg" alt="MegaMart Logo" class="logo">
                <h1>Mega Mart</h1>
            </div>
        </div>
    </header>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" id="searchBar" onkeyup="searchProducts()" placeholder="Search for products..." class="search-bar">
        <button class="search-button" onclick="searchProducts()">🔍</button>
    </div>

    <div class="main-container">
        <main>
            <div class="product-list">
                <?php if (empty($products)) : ?>
                    <p>No products available.</p>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="product">
                            <h3><?= htmlspecialchars($product['name']); ?></h3>
                            <p>Price: $<?= number_format($product['price'], 2); ?></p>
                            <p><?= htmlspecialchars($product['description']); ?></p>
                            <?php if (!empty($product['image'])) : ?>
                                <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                            <?php endif; ?>
                            <form method="POST" action="pages/cart.php">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Chatbot -->
    <div class="chatbot-icon" onclick="toggleChatbot()">💬</div>
    <div class="chatbot-container" id="chatbot">
        <div class="chatbot-header" onclick="toggleChatbot()">Chat with Us!</div>
        <div class="chatbot-messages" id="chatMessages"></div>
        <div class="chatbot-input">
            <input type="text" id="chatInput" placeholder="Ask me anything...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        function toggleChatbot() {
            let chatbot = document.getElementById('chatbot');
            chatbot.style.display = chatbot.style.display === 'flex' ? 'none' : 'flex';
        }
        
        async function sendMessage() {
            let input = document.getElementById("chatInput");
            let message = input.value.trim();
            if (!message) return;

            let chatBox = document.getElementById("chatMessages");
            chatBox.innerHTML += `<div><strong>You:</strong> ${message}</div>`;
            input.value = "";

            let response = await fetch("chatbot_backend.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `message=${encodeURIComponent(message)}`
            });

            let data = await response.json();
            chatBox.innerHTML += `<div><strong>Bot:</strong> ${data.response}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>

    <footer>
        <p>&copy; <?= date('Y'); ?> Online Store. All rights reserved.</p>
    </footer>
</body>
</html>
