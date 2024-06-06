<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "MyDatabase";

try {
    // Establish connection
    $pdo = new PDO("mysql:host=$serverName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
    $pdo->exec($sql);

    // Connect to the created database
    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Disable foreign key checks
    $pdo->exec("SET foreign_key_checks = 0");

    // Drop existing tables if they exist
    $pdo->exec("DROP TABLE IF EXISTS Cars");
    $pdo->exec("DROP TABLE IF EXISTS Person");

    // Enable foreign key checks
    $pdo->exec("SET foreign_key_checks = 1");

    // Create Person table
    $sql = "CREATE TABLE Person (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(255) NOT NULL,
        lastName VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);
    echo "Table Person created successfully<br>";

    // Create Cars table
    $sql = "CREATE TABLE Cars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        model VARCHAR(255) NOT NULL,
        price FLOAT NOT NULL,
        purchaseDate DATETIME NOT NULL,
        personID INT,
        FOREIGN KEY (personID) REFERENCES Person(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Table Cars created successfully<br>";

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_person') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        $sql = "INSERT INTO Person (firstName, lastName, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstname, $lastname, $email]);

        // Redirect to the same page to show the updated list of persons
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Fetch persons
    $persons = $pdo->query("SELECT * FROM Person")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
