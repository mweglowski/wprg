<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<link rel="stylesheet" href="styles.css">
<body>

<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "Student";

$conn = new mysqli($serverName, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists <br/>";
} else {
    die("Error: " . $conn->error);
}

$conn->select_db($dbName);

$sql = "CREATE TABLE IF NOT EXISTS Student (
    StudentID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(255),
    SecondName VARCHAR(255),
    Salary INT,
    DateOfBirth DATE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created or already exists.<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $sql = "DROP TABLE IF EXISTS Student";

    // Handle exception
    if ($conn->query($sql) === TRUE) {
        echo "Table deleted<br>";
    } else {
        echo "Error: " . $conn->error . "<br>";
    }
}

$tableExists = false;
$sql = "SHOW TABLES LIKE 'Student'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $tableExists = true;
}

$conn->close();
?>

<form action="db.php" method="post">
    <h1>Table Management</h1>
    <?php if ($tableExists): ?>
        <button type="submit" name="action" value="delete">Delete Table</button>
    <?php endif; ?>
</form>

</body>
</html>
