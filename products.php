<?php
include 'navbar.php';
include 'db_connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-card h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .product-card p {
            color: #666;
            margin: 8px 0;
        }

        .product-card .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #007BFF;

        }

        .no-data {
            text-align: center;
            font-size: 1.2em;
            color: #666;
        }
    </style>
</head>

<body>
    <h1>All Products</h1>

    <?php

    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="products-container">';


        while ($product = $result->fetch_assoc()) {
            echo '<div class="product-card">
                    <h2>' . htmlspecialchars($product['name']) . '</h2>
                    <p>' . htmlspecialchars($product['description']) . '</p>
                    <p class="price">$' . htmlspecialchars($product['price']) . '</p>
                    <p>Stock: ' . htmlspecialchars($product['stock_quantity']) . '</p>
             
                  </div>';
        }

        echo '</div>';
    } else {

        echo '<p class="no-data">No products available in the database.</p>';
    }


    $conn->close();
    ?>
</body>

</html>