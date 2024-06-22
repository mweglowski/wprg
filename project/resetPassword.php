<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateSql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $hashedPassword, $user_id);

        if ($stmt->execute()) {
            $successMessage = "Password updated successfully.";
        } else {
            $errorMessage = "Error updating password: " . $stmt->error;
        }

        header('Location: account.php');

        $stmt->close();
    } else {
        $errorMessage = "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php
include "navbar.php";
?>

<div class="section">

    <h2 style="text-align: center; margin: 50px;">Reset Password</h2>

    <form action="resetPassword.php" method="post" class="login-form">
        <input class="input" placeholder="New Password" type="password" name="new_password" required>
        <input class="input" placeholder="Confirm Password" type="password" name="confirm_password" required>

        <button type="submit" class="button" style="margin: 1em auto;">Reset Password</button>
    </form>

    <?php
    if (isset($errorMessage)) {
        echo "<p style='color: red; text-align: center;'>$errorMessage</p>";
    }
    ?>
</div>

</body>
</html>
