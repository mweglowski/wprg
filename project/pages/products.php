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

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchSql = '';
if ($searchTerm) {
    $searchSql = "WHERE title LIKE '%$searchTerm%' OR authors LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";
}
$sql = "SELECT id, title, authors, description, price, image FROM products $searchSql";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/products.css">
</head>
<body>
<?php include "navbar.php"; ?>

<img src="../images/sections/products.png" alt="Products Page Image" class="section-image"/>

<?php if ($role === 'admin') { ?>
    <div style="text-align: center; margin: 20px;">
        <a href="newProduct.php" class="link button">Create New Product</a>
    </div>
<?php } ?>

<div style="text-align: center; margin: 20px;">
    <form method="GET" action="">
        <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search content" class="input">
        <button type="submit" class="button">Search</button>
    </form>
</div>

<div>
    <ul class="product-card-list">
        <?php
        if ($result->num_rows > 0) {
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
