<?php
header('Content-Type: application/json');
session_start();
include 'includers/db.php'; // Database connection

// OpenAI API key (replace with your actual API key)
define('OPENAI_API_KEY', 'YOUR_OPENAI_API_KEY');

// Function to call OpenAI API
function getAIResponse($message) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [['role' => 'user', 'content' => $message]],
        'temperature' => 0.7
    ];

    $headers = [
        'Authorization: Bearer ' . OPENAI_API_KEY,
        'Content-Type: application/json'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? "Sorry, I couldn't process your request.";
}

// Function to fetch product recommendations based on keywords
function getProductRecommendations($keyword) {
    global $conn;
    $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE name LIKE ? LIMIT 3");
    $searchTerm = "%$keyword%";
    $stmt->execute([$searchTerm]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($products)) {
        return "No products found matching '$keyword'. Try another search!";
    }

    $response = "Here are some products related to '$keyword':\n";
    foreach ($products as $product) {
        $response .= "🛒 " . $product['name'] . " - $" . number_format($product['price'], 2) . "\n";
    }

    return $response;
}

// Function to check order status
function getOrderStatus($orderId) {
    global $conn;
    $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    return $order ? "Your order #$orderId is currently: " . ucfirst($order['status']) : "Order not found!";
}

// Handling chatbot requests
$userMessage = $_POST['message'] ?? '';
$response = "I'm not sure how to respond to that.";

if (stripos($userMessage, 'recommend') !== false) {
    preg_match('/recommend (.*)/i', $userMessage, $matches);
    $keyword = $matches[1] ?? '';
    if (!empty($keyword)) {
        $response = getProductRecommendations($keyword);
    } else {
        $response = "Please specify a product category or keyword for recommendations.";
    }
} elseif (preg_match('/order status (\d+)/i', $userMessage, $matches)) {
    $orderId = $matches[1];
    $response = getOrderStatus($orderId);
} else {
    $response = getAIResponse($userMessage);
}

echo json_encode(["response" => $response]);
?>
