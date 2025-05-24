<?php
session_start();
include '../includers/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

// Fetch pending sellers who need admin approval
$stmt = $conn->query("SELECT id, username, email FROM users WHERE role = 'seller' AND is_approved = 0");
$pendingSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle seller approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_seller'])) {
    $user_id = $_POST['user_id'];

    // Update the seller's approval status in the database
    $updateStmt = $conn->prepare("UPDATE users SET is_approved = 1 WHERE id = ? AND role = 'seller'");
    $updateStmt->execute([$user_id]);

    // Redirect to refresh the page after approval
    header("Location: admindashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        nav a {
            text-decoration: none;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #45a049;
        }
        .logout {
            background-color: #f44336;
        }
        .logout:hover {
            background-color: #e53935;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <nav>
            <a href="addproduct.php">Add Product</a>
            <a href="manageproducts.php">Manage Products</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>

        <h3>Pending Sellers - Approve as Sellers</h3>
        <table>
            <tr>
                <th>Seller ID</th>
                <th>Seller Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php if (count($pendingSellers) > 0): ?>
                <?php foreach ($pendingSellers as $seller): ?>
                    <tr>
                        <td><?= htmlspecialchars($seller['id']) ?></td>
                        <td><?= htmlspecialchars($seller['username']) ?></td>
                        <td><?= htmlspecialchars($seller['email']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= $seller['id'] ?>">
                                <button type="submit" name="approve_seller" onclick="return confirm('Are you sure you want to approve this seller?');">
                                    Approve as Seller
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No pending sellers for approval.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <footer>
        <p>&copy; <?= date("Y"); ?> Admin Dashboard</p>
    </footer>
</body>
</html>
