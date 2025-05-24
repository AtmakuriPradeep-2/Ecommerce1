<?php
session_start();
include '../includers/db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../sellerlogin.php");
    exit();
}

// Fetch user role and approval status
$stmt = $conn->prepare("SELECT role, is_approved FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Restrict access: Only admin or approved sellers can add products
if (!($user['role'] === 'admin' || ($user['role'] === 'seller' && $user['is_approved'] == 1))) {
    echo "<h3>Access Denied! Only approved sellers and admins can add products.</h3>";
    exit();
}

if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $image = $_FILES['image'];

    // Validate inputs
    if (empty($name) || empty($price) || empty($description) || empty($image['name'])) {
        echo "<h3>All fields are required.</h3>";
        exit();
    }
    
    if (!is_numeric($price) || $price <= 0) {
        echo "<h3>Invalid price. It must be a positive number.</h3>";
        exit();
    }

    // Validate image format
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_types)) {
        echo "<h3>Invalid image format! Allowed formats: JPG, JPEG, PNG, GIF.</h3>";
        exit();
    }

    // Generate unique filename
    $unique_filename = uniqid("product_", true) . "." . $file_ext;
    $upload_path = "../images/" . $unique_filename;

    if (!move_uploaded_file($image['tmp_name'], $upload_path)) {
        echo "<h3>Failed to upload image.</h3>";
        exit();
    }

    // Insert into database
    try {
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, seller_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $description, $unique_filename, $_SESSION['user_id']]);
        echo "<h3>Product added successfully!</h3>";
    } catch (PDOException $e) {
        echo "<h3>Database error: " . $e->getMessage() . "</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <label for="image">Image:</label>
            <input type="file" name="image" id="image" required>

            <button type="submit" name="add_product">Add Product</button>
        </form>
        <div class="back-link">
            <a href="Manageproducts.php">Back to Manage Products</a>
        </div>
    </div>
</body>
</html>
