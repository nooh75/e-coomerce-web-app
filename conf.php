<?php
include 'db_connection.php';
include 'navbar.php';

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['order_id'])) {
    echo "Error: Invalid request.";
    exit();
}

$order_id = $_SESSION['order_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    $shipping_address = $_POST['shipping_address'];
    $payment_method = $_POST['payment_method'];

    if (empty($shipping_address) || empty($payment_method)) {
        echo "Please provide shipping address and payment method.";
        exit();
    }

    $conn->begin_transaction();


    $shipping_query = "INSERT INTO shipping_details (order_id, shipping_address, shipping_date) 
                        VALUES ($order_id, '$shipping_address', NOW())";
    $conn->query($shipping_query);

    $status = 'success';
    $payment_query = "INSERT INTO payments (order_id, payment_method, status) 
                        VALUES ($order_id, '$payment_method', '$status')";
    $conn->query($payment_query);

    $update_order_query = "UPDATE orders SET status = 'Complete' WHERE id = $order_id";
    $conn->query($update_order_query);

    $conn->commit();

    unset($_SESSION['order_id']);

    echo "Order confirmed successfully! Your order is now complete.";


    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input,
        select,
        textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-success {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-success:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 16px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Confirm Your Order</h1>
        <form method="POST">
            <label for="shipping_address">Shipping Address:</label>
            <textarea name="shipping_address" id="shipping_address" rows="4" required></textarea>

            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>

            <button type="submit" name="confirm_order" class="btn-success">Confirm Order</button>
        </form>
    </div>
</body>

</html>