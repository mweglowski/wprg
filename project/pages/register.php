<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $role = "user";
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkEmailSql = "SELECT email FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $error = "Email already exists. Please use a different email.";
    } else {
        $sql = "INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $role);

        if ($stmt->execute()) {
            header("location: login.php");
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
<?php
include "navbar.php";
?>
<img src="../images/sections/login.png" alt="Register Page Image" class="section-image"/>
<h2 style="text-align: center; margin: 50px;">REGISTER</h2>

<form action="register.php" method="post" class="login-form">
    <input class="input" type="text" name="firstName" placeholder="First Name" required />
    <input class="input" type="text" name="lastName" placeholder="Last Name" required />
    <input class="input" type="email" name="email" placeholder="Email" required />
    <input class="input" type="password" name="password" placeholder="Password" required />
    <button type="submit" class="button" style="margin: auto; margin-top: 20px;">Register</button>
</form>

<?php
if (isset($error)) {
    echo "<p style='color: red; text-align: center;'>$error</p>";
}
?>

<div class="login-register-paragraph">
    Already have an account? <a href="login.php">Login</a>
</div>
</body>
</html>
