<?php
session_start();
include '../includers/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Alert message for duplicate username or email
        echo "<script>alert('Username or Email already exists. Please choose another.'); window.location.href='sellerregister.php';</script>";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Set role as 'seller' and is_approved as 0 (pending approval)
        $role = 'seller';
        $is_approved = 0;

        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, is_approved) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword, $role, $is_approved])) {
            echo "<script>alert('Registration successful! Wait for admin approval.'); window.location.href='sellerlogin.php';</script>";
        } else {
            echo "<script>alert('Error in registration. Try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 40%; margin: 50px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        label, input { display: block; width: 100%; margin-bottom: 10px; }
        input { padding: 8px; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Seller Registration</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
