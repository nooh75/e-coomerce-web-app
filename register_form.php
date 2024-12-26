<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>User Registration</h1>
    <form method="POST" action="register.php">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone Number" required><br>
        <textarea name="address" placeholder="Address" required></textarea><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>