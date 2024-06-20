<?php
session_start();

// Fetch product details for items in the cart
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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$totalPrice = 0;
$productIds = array_keys($cartItems);

if (!empty($productIds)) {
    $productIdsString = implode(",", array_map('intval', $productIds));
    $sql = "SELECT id, title, authors, price, image FROM products WHERE id IN ($productIdsString)";
    $result = $conn->query($sql);

    // CALCULATE TOTAL PRICE
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $productId = $row["id"];
            $totalPrice += $row["price"] * $cartItems[$productId];
        }
    }
} else {
    $result = false; // No products to display
}

// Handle purchase action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase'])) {
    $user_id = $_SESSION['user_id'];
    $conn->autocommit(FALSE); // Turn off auto-commit

    // Insert order
    $insertOrderSql = "INSERT INTO orders (user_id) VALUES (?)";
    $stmt = $conn->prepare($insertOrderSql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id;

        // Insert order products
        $insertOrderProductSql = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertOrderProductSql);

        foreach ($cartItems as $productId => $quantity) {
            $stmt->bind_param("iii", $orderId, $productId, $quantity);
            if (!$stmt->execute()) {
                $conn->rollback(); // Rollback on error
                die("Error inserting order products: " . $stmt->error);
            }
        }

        $conn->commit(); // Commit transaction
        $stmt->close();

        // Clear the cart
        $_SESSION['cart'] = [];

        // Redirect to orders section
        header("Location: account.php?section=orders");
        exit();
    } else {
        $conn->rollback(); // Rollback on error
        die("Error inserting order: " . $stmt->error);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="payment.css">
</head>
<body>
<?php include "navbar.php"; ?>

<h2 style="text-align: center; margin: 50px;">Payment</h2>

<div>
    <?php if ($totalPrice > 0): ?>
        <div class="payment-total-price">
            <div>Total Price:</div>
            <div>$<?php echo $totalPrice; ?></div>
        </div>
    <?php endif; ?>
</div>

<!-- PURCHASE BUTTON -->
<form method="POST" action="payment.php">
    <button type="submit" name="purchase" class="button" style="margin: 5em auto;">Purchase</button>
</form>

</body>
</html>
