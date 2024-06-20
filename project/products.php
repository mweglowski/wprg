<?php
session_start();

$servername = "localhost"; // Change this to your database server name
$username = "root";        // Change this to your database username
$password = "";            // Change this to your database password
$dbname = "project";       // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
}

// Fetch products from the database
$sql = "SELECT id, title, authors, description, price, image FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php
include "navbar.php";
?>

<h2 style="text-align: center; margin: 50px;">PRODUCTS</h2>

<!-- PRODUCTS LIST -->
<div>
    <ul class="product-card-list">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<li class="product-card">';
                echo '<img class="product-card-image" src="' . $row["image"] . '" alt="Product Image" />';
                echo '<div class="product-card-title">' . $row["title"] . '</div>';
                echo '<div class="product-card-authors">' . $row["authors"] . '</div>';
                echo '<div class="product-card-description">' . $row["description"] . '</div>';
                echo '<div class="product-card-button-and-price">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
                echo '<button type="submit" class="button">Add to Cart</button>';
                echo '</form>';
                echo '<div class="product-card-price">$' . $row["price"] . '</div>';
                echo '</div>';
                echo '</li>';
            }
        } else {
            echo "No products found.";
        }
        $conn->close();
        ?>
    </ul>
</div>

</body>
</html>
