<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "MyDatabase";

try {
    // CONNECT TO DB
    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // LISTEN TO REGISTER CLICK AND PERFORM INSERT OPERATION
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phoneNumber"];
        $password = $_POST["password"];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (firstName, lastName, email, phoneNumber, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $phoneNumber, $hashedPassword]);

        echo "<div class='notification'>User Added Successfully.</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<form action="register.php" method="post">
    <h1>Registration Form</h1>

    <input type="text" name="firstName" placeholder="First Name" required/>

    <input type="text" name="lastName" placeholder="Last Name" required/>

    <input type="text" name="phoneNumber" placeholder="Phone Number" required/>

    <input type="email" name="email" placeholder="Email" required/>

    <input type="password" name="password" placeholder="Password" required/>

    <button type="submit" value="register" name="register">Register</button>
</form>


<form action="users.php" method="post">
    <button type="submit" value="users">See Registered Users</button>
</form>


</body>
</html>
