<?php
include('db_connection.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT first_name FROM customers WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        nav {
            background-color: #007BFF;
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #0056b3;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007BFF;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        p {
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
    </header>

    <nav>
        <a href="products.php">Browse Products</a>
        <a href="place_order.php">Place Order</a>
        <a href="view_cart.php">My Orders</a>
        <a href="profile.php">My Profile</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>
        <h2>Quick Stats</h2>
        <?php
        $order_count = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE customer_id = $user_id")->fetch_assoc()['total'];
        echo "<p>You have placed $order_count orders.</p>";
        ?>
    </main>
</body>

</html>