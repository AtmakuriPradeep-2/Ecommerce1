<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

include '../includers/db.php';

// Check if product_id is provided in the request
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Retrieve product image path before deleting
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $imagePath = "../images/" . $product['image'];

        // Delete product from the database
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);

        // Remove image file if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        echo "<script>alert('Product deleted successfully!'); window.location.href='Manageproducts.php';</script>";
    } else {
        echo "<script>alert('Product not found!'); window.location.href='Manageproducts.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='Manageproducts.php';</script>";
}
?>
