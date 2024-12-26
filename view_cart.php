<?php
include 'db_connection.php';
include 'navbar.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User is not logged in.";
        exit();
    }
    $customer_id = $_SESSION['user_id'];
    $total_amount = 0;

    $conn->begin_transaction();



    $insert_order_query = "INSERT INTO orders (customer_id, status, total_amount) VALUES ($customer_id, 'Pending', $total_amount)";
    $conn->query($insert_order_query);
    $order_id = $conn->insert_id;


    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_query = "SELECT price FROM products WHERE id = $product_id";
        $product_result = $conn->query($product_query);
        $product = $product_result->fetch_assoc();
        $price = $product['price'];

        $quantity = (int)$quantity;
        $price = (float)$price;

        $subtotal = $price * $quantity;
        $total_amount += $subtotal;

        $insert_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
        $conn->query($insert_item_query);
    }

    $update_order_query = "UPDATE orders SET total_amount = $total_amount WHERE id = $order_id";
    $conn->query($update_order_query);


    $conn->commit();


    $_SESSION['cart'] = [];

    echo "<div class='message-success'>Order placed successfully!</div>";

    $_SESSION['order_id'] = $order_id;

    echo "<a href='conf.php'><button class='btn-success'>Confirm Order</button></a>";


    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cart_total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $quantity):
                        $product_query = $conn->query("SELECT name, price FROM products WHERE id = $product_id");
                        $product = $product_query->fetch_assoc();

                        $quantity = (int)$quantity;
                        $subtotal = $product['price'] * $quantity;
                        $cart_total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= $quantity ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>$<?= number_format($cart_total, 2) ?></th>
                    </tr>
                </tbody>
            </table>
            <form method="POST">
                <button type="submit" name="place_order" class="btn-success">Place Order</button>
            </form>
        <?php else: ?>
            <div class="empty-cart">
                <p>Your cart is empty. <a href="place_order.php">Go back to products</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>