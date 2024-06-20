<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "project";

$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$createDb = "CREATE DATABASE IF NOT EXISTS `$dbName`";
if ($conn->query($createDb) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->select_db($dbName);

// Drop existing tables if they exist
$tables = ['users', 'products', 'orders', 'order_products'];
foreach ($tables as $table) {
    $conn->query("DROP TABLE IF EXISTS `$table`");
}

// Create users table
$createUsersTable = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `firstName` VARCHAR(50) NOT NULL,
    `lastName` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(50) NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createUsersTable);

// Create products table
$createProductsTable = "CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `image` VARCHAR(255) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `authors` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `quantity` INT NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createProductsTable);

// Create orders table
$createOrdersTable = "CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
)";
$conn->query($createOrdersTable);

// Create order_products table
$createOrderProductsTable = "CREATE TABLE IF NOT EXISTS `order_products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
)";
$conn->query($createOrderProductsTable);

// Insert initial users
$insertUsers = [
    [
        'firstName' => 'Admin',
        'lastName' => 'User',
        'email' => 'admin@example.com',
        'password' => password_hash('adminpass', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john@example.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];

$insertUserStmt = $conn->prepare("INSERT INTO `users` (`firstName`, `lastName`, `email`, `password`, `role`) VALUES (?, ?, ?, ?, ?)");
foreach ($insertUsers as $user) {
    $insertUserStmt->bind_param("sssss", $user['firstName'], $user['lastName'], $user['email'], $user['password'], $user['role']);
    $insertUserStmt->execute();
}
$insertUserStmt->close();

// Insert initial products
$products = [
    [
        'image' => './images/rl_sutton.jpg',
        'title' => 'Reinforcement Learning: An Introduction',
        'authors' => 'Richard S. Sutton and Andrew G. Barto',
        'description' => 'The classic book on reinforcement learning.',
        'price' => 59.99,
        'quantity' => 10
    ],
    [
        'image' => './images/dl_goodfellow.jpg',
        'title' => 'Deep Learning',
        'authors' => 'Ian Goodfellow, Yoshua Bengio, and Aaron Courville',
        'description' => 'A comprehensive introduction to the field of deep learning.',
        'price' => 79.99,
        'quantity' => 15
    ],
    [
        'image' => './images/cs_interdisciplinary.jpg',
        'title' => 'Computer Science: An Interdisciplinary Approach',
        'authors' => 'Robert Sedgewick and Kevin Wayne',
        'description' => 'A broad introduction to computer science.',
        'price' => 69.99,
        'quantity' => 20
    ],
    [
        'image' => './images/rl_szepesvari.jpg',
        'title' => 'Algorithms for Reinforcement Learning',
        'authors' => 'Csaba Szepesvári',
        'description' => 'A detailed guide on algorithms for reinforcement learning.',
        'price' => 49.99,
        'quantity' => 12
    ],
    [
        'image' => './images/ml_geron.jpg',
        'title' => 'Hands-On Machine Learning with Scikit-Learn, Keras, and TensorFlow',
        'authors' => 'Aurélien Géron',
        'description' => 'A practical guide to machine learning with popular Python libraries.',
        'price' => 89.99,
        'quantity' => 25
    ]
];

$insertProductStmt = $conn->prepare("INSERT INTO `products` (`image`, `title`, `authors`, `description`, `price`, `quantity`) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($products as $product) {
    $insertProductStmt->bind_param("ssssdi", $product['image'], $product['title'], $product['authors'], $product['description'], $product['price'], $product['quantity']);
    $insertProductStmt->execute();
}
$insertProductStmt->close();

// Show tables
$showTables = "SHOW TABLES";
$result = $conn->query($showTables);

if ($result->num_rows > 0) {
    echo "Tables in database '$dbName':<br>";
    while($row = $result->fetch_assoc()) {
        echo $row[array_keys($row)[0]] . "<br>";
    }
} else {
    echo "No tables found in database.<br>";
}

// Fetch and display users
$fetchUsers = "SELECT * FROM `users`";
$result = $conn->query($fetchUsers);

if ($result->num_rows > 0) {
    echo "Users:<br>";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["firstName"] . " " . $row["lastName"] . " - Email: " . $row["email"] . " - Role: " . $row["role"] . " - Created At: " . $row["createdAt"] . "<br>";
    }
} else {
    echo "No users found.<br>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php include "navbar.php"; ?>
</body>
</html>
