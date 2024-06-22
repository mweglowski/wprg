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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
<?php include "navbar.php"; ?>

<img src="../images/sections/home.png" alt="Home Page Image" class="section-image"/>

<h2 style="text-align: center; margin: 50px;">Welcome to our shop!</h2>

</body>
</html>
