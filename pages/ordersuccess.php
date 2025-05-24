<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .checkmark {
            font-size: 80px;
            color: #28a745;
            animation: bounce 1s ease-in-out;
        }
        .message {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }
        .redirect {
            margin-top: 20px;
            font-size: 16px;
            color: #666;
        }
        @keyframes bounce {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); }
        }
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: red;
            top: 0;
            opacity: 0.8;
            animation: fall 3s linear infinite;
        }
        @keyframes fall {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(600px) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkmark">✔</div>
        <div class="message">Your order has been placed successfully!</div>
        <div class="redirect">Redirecting to your orders in <span id="timer">5</span> seconds...</div>
    </div>

    <script>
        // Countdown Redirect
        let time = 5;
        setInterval(() => {
            time--;
            document.getElementById('timer').innerText = time;
            if (time === 0) {
                window.location.href = 'orders.php';
            }
        }, 1000);

        // Confetti Effect
        function createConfetti() {
            const confetti = document.createElement('div');
            confetti.classList.add('confetti');
            confetti.style.left = Math.random() * 100 + "vw";
            confetti.style.backgroundColor = ["#ffcc00", "#ff6600", "#ff3366", "#3399ff", "#33cc33"][Math.floor(Math.random() * 5)];
            document.body.appendChild(confetti);
            setTimeout(() => confetti.remove(), 3000);
        }
        setInterval(createConfetti, 200);
    </script>
</body>
</html>
