<?php
include 'db_connection.php';

if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_sql = "DELETE FROM customers WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);

    if ($delete_stmt->execute()) {
        echo "<div class='success-message'>User deleted successfully!</div>";
    } else {
        echo "<div class='error-message'>Error deleting user.</div>";
    }
    $delete_stmt->close();
}

$users_sql = "SELECT id, first_name, last_name FROM customers";
$users_result = $conn->query($users_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="container">
        <h1>Manage Users</h1>
        <?php
        if ($users_result->num_rows > 0) {
            while ($user = $users_result->fetch_assoc()) {
                echo "<div class='user-item'>";
                echo "<span>" . $user['first_name'] . " " . $user['last_name'] . "</span>";
                echo "<a href='?delete_user=" . $user['id'] . "' class='delete-btn'>Delete</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </div>
</body>

</html>
<?php
$conn->close();
?>