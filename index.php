<?php
// Start session only if it's not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includers/db.php'; // Database connection

// Check if using PDO or MySQLi
try {
    $stmt = $conn->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch products using PDO
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
    
    <script>
        function searchProducts() {
            let input = document.getElementById('searchBar').value.toLowerCase();
            let products = document.getElementsByClassName('product');
            
            for (let product of products) {
                let name = product.getElementsByTagName('h3')[0].innerText.toLowerCase();
                if (name.includes(input)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            }
        }
    </script>
    <style>
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
            background-color:none;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            height: 100px;
            width:120px;
            margin-right: 15px;
        }
        .nav-links {
            display: flex;
            align-items: center;
        }
        .nav-links a, .nav-links form {
            margin-left: 15px;
            text-decoration: none;
            font-size: 16px;
            color: #333;
        }
        .nav-links form {
            display: inline;
        }
        .cart{
            background-color:none;
            color: white;
            border: none;
            padding: 5px 5px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 50px;
            height: 40px;
            margin-right: 8px;
        
        }
        



        

    
    </style>
</head>
<body>


    <header>
    <?php include 'pages/menubar.php'; ?>
        
    </header>
    
    <!-- Enhanced Search Bar -->
    
    
    <div class="main-container">
        <main>
            
        <div id="product-list" class="product-list">

                <?php if (empty($products)) : ?>
                    <p>No products available.</p>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="product">
                            <h3><?= htmlspecialchars($product['name']); ?></h3>
                            <p>Price: ₹<?= number_format($product['price'], 2); ?></p>
                            <p><?= htmlspecialchars($product['description']); ?></p>
                            <?php if (!empty($product['image'])) : ?>
                                <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                            <?php endif; ?>
                            <form method="POST" action="pages/cart.php">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <button type="submit" name="add_to_cart" class="add-to-cart-button">
    <img src="images/cart3.png" alt="Cart" width="32" height="32" style="vertical-align: middle; margin-right: 5px;">
    Add to Cart
</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <?php
// Start session only if it's not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includers/db.php'; // Database connection

// Check if using PDO or MySQLi
try {
    $stmt = $conn->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch products using PDO
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
    <link rel="stylesheet" href="css/productstyle.css">
    <script>
        function searchProducts() {
            let input = document.getElementById('searchBar').value.toLowerCase();
            let products = document.getElementsByClassName('product');
            
            for (let product of products) {
                let name = product.getElementsByTagName('h3')[0].innerText.toLowerCase();
                if (name.includes(input)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            }
        }
    </script>
    <style>
        .chatbot-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
        }
        .chatbot-window {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            height: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(40, 40, 40, 0.3);
            display: none;
            flex-direction: column;
        }
        .chatbot-header {
            background: #ff9800;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 16px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .chatbot-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f9f9f9;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}
        .chatbot-input {
            display: flex;
            border-top: 1px solid #ddd;
        }
        .chatbot-input input {
            flex: 1;
            padding: 10px;
            border: none;
            border-bottom-left-radius: 10px;
        }
        .chatbot-input button {
            background: #ff9800;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-bottom-right-radius: 10px;
        }



        







    </style>
</head>
<body>
    
    <button class="chatbot-button" onclick="toggleChatbot()">💬</button>
    <div class="chatbot-window" id="chatbot">
    <div class="chatbot-header">
        Chat with us
        <span class="close-chatbot" onclick="toggleChatbot()">❌</span>
    </div>
    <div class="chatbot-messages" id="chat-messages"></div>
    <div class="chatbot-input">
        <input type="text" id="chat-input" placeholder="Type a message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<style>
    .close-chatbot {
        float: right;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
    }
    .close-chatbot:hover {
        color: red;
    }
</style>

    <div class="chatbot-window" id="chatbot">
        <div class="chatbot-header">Chat with us</div>
        <div class="chatbot-messages" id="chat-messages"></div>
        <div class="chatbot-input">
            <input type="text" id="chat-input" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
    
    <script>
 let selectedOption = ""; // To track the user's choice

function toggleChatbot() {
    let chatbot = document.getElementById("chatbot");
    let chatMessages = document.getElementById("chat-messages");

    chatbot.style.display = chatbot.style.display === "none" ? "flex" : "none";

    // Show options only when chatbot opens and no messages exist
    if (chatbot.style.display === "flex" && chatMessages.childElementCount === 0) {
        let botMessage = document.createElement("div");
        botMessage.innerHTML = "🤖 <b>Welcome!</b><br>Choose an option:<br>1️⃣ Track Order<br>2️⃣ Cancel Order<br>3️⃣ Browse Products<br>4️⃣ Contact Support";
        chatMessages.appendChild(botMessage);
    }
}

function sendMessage() {
    let input = document.getElementById("chat-input");
    let message = input.value.trim();
    if (message === "") return;

    let chatMessages = document.getElementById("chat-messages");

    // Add user message
    let userMessage = document.createElement("div");
    userMessage.innerHTML = `<b>You:</b> ${message}`;
    chatMessages.appendChild(userMessage);
    input.value = "";

    setTimeout(() => {
        let botMessage = document.createElement("div");

        if (message.startsWith("#")) {
            let orderId = message.substring(1); // Remove "#" from input

            fetch(`http://localhost/Ecommerce/pages/check_order_status.php?order_id=${orderId}`)
                .then(response => response.text())
                .then(status => {
                    let botResponse = "";

                    if (status.trim().toLowerCase() === "canceled") {
                        botResponse = `⚠️ <b>Order Already Canceled</b><br>❌ Order #${orderId} has already been canceled.<br>🔍 Need help? <a href="mailto:support@megamart.com" style="color: blue; font-weight: bold;">Contact Support</a>`;
                    } else if (status.trim().toLowerCase() === "invalid") {
                        botResponse = `🚫 <b>Invalid Order ID</b><br>🔎 Please check and enter a valid order ID.`;
                    } else {
                        if (selectedOption === "1") { 
                            // If user selected "Track Order"
                            botResponse = `📦 <b>Track Order</b><br>✅ <a href="http://localhost/Ecommerce/pages/trackorder.php?order_id=${orderId}" target="_blank" style="color: green; font-weight: bold;">Track Order #${orderId}</a>`;
                        } else if (selectedOption === "2") { 
                            // If user selected "Cancel Order"
                            botResponse = `❌ <b>Cancel Order</b><br>🚫 <a href="http://localhost/Ecommerce/pages/cancelorder.php?order_id=${orderId}" target="_blank" style="color: red; font-weight: bold;">Cancel Order #${orderId}</a>`;
                        } else {
                            botResponse = `⚠️ <b>Invalid Request</b><br>📌 Please select an option first:<br>1️⃣ Track Order<br>2️⃣ Cancel Order`;
                        }
                    }

                    botMessage.innerHTML = botResponse;
                    chatMessages.appendChild(botMessage);
                })
                .catch(error => {
                    botMessage.innerHTML = "⚠️ <b>Error fetching order status.</b> Please try again later.";
                    chatMessages.appendChild(botMessage);
                    console.error("Error fetching order status:", error);
                });

        } else {
            let response = "";
            switch (message) {
                case "1":
                    selectedOption = "1"; // Track Order
                    response = "🛒 <b>Track Order</b><br>📌 Enter your order ID prefixed with <b>'#'</b> to track.<br>Example: <b>#35</b>";
                    break;
                case "2":
                    selectedOption = "2"; // Cancel Order
                    response = "❌ <b>Cancel Order</b><br>🔄 Enter your order ID prefixed with <b>'#'</b> to cancel.<br>Example: <b>#35</b>";
                    break;
                case "3":
                    selectedOption = ""; // Reset option
                    response = "🛍️ <b>Browse Products</b><br>🔗 <a href='http://localhost/Ecommerce/landingpage.php' target='_blank' style='color: blue; text-decoration: underline; font-weight: bold;'>View Products</a>";
                    break;
                case "4":
                    selectedOption = ""; // Reset option
                    response = "📞 <b>Contact Support</b><br>📩 Email: <b>support@megamart.com</b>";
                    break;
                default:
                    selectedOption = ""; // Reset option
                    response = "⚠️ <b>Invalid option</b><br>📌 Please choose:<br>1️⃣ Track Order<br>2️⃣ Cancel Order<br>3️⃣ Browse Products<br>4️⃣ Contact Support";
            }
            botMessage.innerHTML = response;
            chatMessages.appendChild(botMessage);
        }
    }, 1000);
}

    </script>
    </script>
</body>
</html>

   
   

    

    <footer>
        <p>&copy; <?= date('Y'); ?> Online Store. All rights reserved.</p>
    </footer>
</body>
</html>
