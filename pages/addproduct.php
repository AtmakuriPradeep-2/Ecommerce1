<?php
session_start();
include '../includers/db.php';

// Restrict access to only logged-in sellers
if (!isset($_SESSION['seller_id'])) {
    header("Location: sellerlogin.php");
    exit();
}

$seller_id = $_SESSION['seller_id']; // Logged-in seller ID

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $image = $_FILES['image'];

    // Validate inputs
    if (empty($name) || empty($price) || empty($description) || empty($image['name'])) {
        $error = "All fields are required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Invalid price. Must be a positive number.";
    } else {
        // Allow all image types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg'];
        $file_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $mime_type = mime_content_type($image['tmp_name']);

        // Check if file is an image
        if (strpos($mime_type, 'image') === false) {
            $error = "Invalid file type. Only images are allowed.";
        } elseif (!in_array($file_ext, $allowed_types)) {
            $error = "Invalid image format. Allowed: JPG, JPEG, PNG, GIF, BMP, WEBP, TIFF, SVG.";
        } elseif ($image['size'] > 5 * 1024 * 1024) { // 5MB limit
            $error = "Image size must be less than 5MB.";
        } else {
            // Ensure the correct directory exists
            $upload_dir = "../images/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Rename image to avoid overwriting
            $unique_filename = uniqid("product_", true) . "." . $file_ext;
            $upload_path = $upload_dir . $unique_filename;

            // Move uploaded file securely
            if (move_uploaded_file($image['tmp_name'], $upload_path)) {
                try {
                    // Insert product details into database
                    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, seller_id) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $price, $description, $unique_filename, $seller_id]);

                    $success = "Product added successfully!";
                } catch (PDOException $e) {
                    $error = "Database error: " . $e->getMessage();
                }
            } else {
                $error = "Failed to upload image. Check directory permissions.";
            }
        }
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
        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

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
            <a href="manageproducts.php">Back to Manage Products</a>
        </div>
    </div>
</body>
</html>
