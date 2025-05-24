<?php
include('../includers/db.php');  // Database connection
session_start();

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = 'user'; // Default role for users

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('Email is already registered!'); window.location.href='/Ecommerce/pages/register.php';</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password, $role]);

        // Log the user in after successful registration
        $_SESSION['user_id'] = $conn->lastInsertId();

        echo "<script>alert('Registration successful!'); window.location.href='../landingpage.php';</script>";
        exit();
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle at top left, #000428, #004e92);
            overflow: hidden;
            position: relative;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            box-shadow: 0px 10px 40px rgba(0, 255, 255, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 10;
            animation: fadeIn 1s ease-in-out;
            border: 2px solid rgba(0, 255, 255, 0.3);
        }
        h2 {
            color: #00e1ff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            color: #fff;
            font-size: 1em;
            display: block;
            text-align: left;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            outline: none;
            background: rgba(0, 0, 0, 0.3);
            color: #00e1ff;
            transition: all 0.3s ease-in-out;
            border: 1px solid rgba(0, 255, 255, 0.3);
        }
        input:focus {
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 10px #00e1ff;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #007acc;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        button:hover {
            background: #005bb5;
            box-shadow: 0px 0px 20px #00e1ff;
        }
        .glow {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        .glow::before, .glow::after {
            content: "";
            position: absolute;
            width: 50px;
            height: 50px;
            background: radial-gradient(circle, rgba(0, 255, 255, 0.7), transparent);
            border-radius: 50%;
            animation: floatAround 5s infinite ease-in-out;
        }
        .glow::before {
            top: 5%;
            left: 10%;
        }
        .glow::after {
            bottom: 10%;
            right: 15%;
        }
        @keyframes floatAround {
            0% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(20px) translateX(20px); }
            100% { transform: translateY(0px) translateX(0px); }
        }
    </style>
</head>
<body>
    <div class="glow"></div>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="register.php">
            <label>Full Name:</label>
            <input type="text" name="fullname" required placeholder="Enter your full name">
            <label>Email:</label>
            <input type="email" name="email" required placeholder="Enter your email">
            <label>Password:</label>
            <input type="password" name="password" required placeholder="Enter your password">
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>
</html>