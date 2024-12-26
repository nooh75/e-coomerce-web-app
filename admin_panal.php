<?php
include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <nav>
        <a href="dashboard.php">Home</a>
    </nav>
    <div class="container">
        <h1>Admin Panel</h1>
        <div class="btn-container">
            <a href="add_product.php" class="btn">Add Product</a>
            <a href="manage_users.php" class="btn">Manage Users</a>
        </div>
    </div>
</body>

</html>