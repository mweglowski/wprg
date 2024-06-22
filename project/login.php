<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "project";

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;

            echo "Session after login: ";
            print_r($_SESSION); // Debugging: Print session after login

            header("Location: products.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php
include "navbar.php";
?>
<img src="./images/sections/login.png" alt="Login Page Image" class="section-image"/>
<h2 style="text-align: center; margin: 50px;">LOGIN</h2>

<form action="login.php" method="post" class="login-form">
    <input class="input" type="text" name="email" placeholder="Email" required />
    <input class="input" type="password" name="password" placeholder="Password" required />
    <button type="submit" class="button" style="margin: auto; margin-top: 20px;" name="login">Login</button>
</form>

<?php
if (isset($error)) {
    echo "<p style='color: red; text-align: center;'>$error</p>";
}
?>

<div class="login-register-paragraph">
    Don't have an account? <a href="register.php">Register</a>
</div>
</body>
</html>
