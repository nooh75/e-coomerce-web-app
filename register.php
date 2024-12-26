<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, email, password_hash, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $password, $phone, $address);

    if ($stmt->execute()) {
        header("Location: login.php?registered=true");
    } else {
        echo "Error: " . $stmt->error;
    }
}
// $sql = "INSERT INTO customers (first_name, last_name, email, password_hash, phone, address)
// VALUES ('$first_name', '$last_name', '$email', '$password', '$phone', '$address')";
// $result = $conn->query($sql);

//this is the defulat way but it may lead to sqli
