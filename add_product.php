<?php
include 'db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];


    $stmt = $conn->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $description);
    $stmt->execute();
    echo "<div class='success-message'>Product added successfully!</div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Add Product</h1>
        <form method="POST">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" required>
            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>
</body>

</html>