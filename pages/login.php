<?php
include('../includers/db.php');  
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; 
        header("Location: ../landingpage.php"); 
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Commerce</title>
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
        .login-container {
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
            position: relative;
            overflow: hidden;
        }
        button:hover {
            background: #005bb5;
            box-shadow: 0px 0px 20px #00e1ff;
        }
        .error-message {
            color: #ffcccb;
            font-size: 1em;
            text-align: center;
            margin-top: 10px;
        }
        .google-login {
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }
        .google-login a {
            display: flex;
            align-items: center;
            background-color:rgb(90, 209, 253);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1.1em;
            transition: 0.3s;
        }
        .google-login a:hover {
            background-color:rgb(101, 182, 245);
        }
        .google-login a img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 3D Light Pulses at the margins */
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
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required placeholder="Enter your email">
            <label>Password:</label>
            <input type="password" name="password" required placeholder="Enter your password">
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        
        <div class="google-login">
            <a href="googlelogin.php">
                <img src="../images/google.jpg" alt="Google"> Continue with Google
            </a>
        </div>
    </div>
</body>
</html>
