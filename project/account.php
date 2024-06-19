<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT firstName, lastName, email, role, password, createdAt FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $role, $password, $createdAt);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="account.css">
</head>
<body>
<?php
include "navbar.php";
?>

<div class="section">

    <h2 style="text-align: center; margin: 50px;">Account</h2>

    <div style="border-bottom: 2px solid black; display: flex; justify-content: center; gap: 10px;">
        <button class="button">Account Details</button>
        <button class="button">Orders</button>
    </div>

    <div class="account-details">
        <h3>Account Details</h3>

        <div class="account-detail">
            <strong>First Name:</strong> <p><?php echo htmlspecialchars($firstName); ?></p>
        </div>
        <div class="account-detail">
            <strong>Last Name:</strong> <p><?php echo htmlspecialchars($lastName); ?></p>
        </div>
        <div class="account-detail">
            <strong>Email:</strong> <p><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="account-detail">
            <strong>Password:</strong> <p>xxxxxxxxxx</p>
        </div>
        <div class="account-detail">
            <strong>Created At:</strong> <p><?php echo htmlspecialchars($createdAt); ?></p>
        </div>
    </div>

    <a href="resetPassword.php" class="button" style="font-size: 0.85em; text-decoration: none; margin: 3em auto;">Reset Password</a>
</div>

</body>
</html>
