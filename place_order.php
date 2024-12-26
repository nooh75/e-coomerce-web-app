<?php

include 'db_connection.php';
include 'navbar.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$query = "SELECT * FROM products";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = 1;
    $customer_id = $_SESSION['user_id'];

    $product_query = "SELECT stock_quantity FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_query);
    $product = $product_result->fetch_assoc();

    if ($product) {
        $available_stock = $product['stock_quantity'];

        if ($quantity <= $available_stock) {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'quantity' => $quantity,
                    'customer_id' => $customer_id
                ];
            }

            $new_stock = $available_stock - $quantity;
            $update_stock_query = "UPDATE products SET stock_quantity = $new_stock WHERE id = $product_id";
            $conn->query($update_stock_query);

            $_SESSION['cart_message'] = "Product added to cart successfully!";
        } else {
            $_SESSION['cart_message'] = "Insufficient stock available!";
        }
    }
}

if (isset($_SESSION['cart_message'])) {
    echo "<p style='color: green; text-align: center;'>{$_SESSION['cart_message']}</p>";
    unset($_SESSION['cart_message']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <div class="container">
        <h1>Available Products</h1>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>$<?= number_format($row['price'], 2) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>