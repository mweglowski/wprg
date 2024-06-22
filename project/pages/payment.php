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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $productId = $row["id"];
            $totalPrice += $row["price"] * $cartItems[$productId];
        }
    }
} else {
    $result = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase'])) {
    $user_id = $_SESSION['user_id'];
    $conn->autocommit(FALSE);

    $insertOrderSql = "INSERT INTO orders (user_id) VALUES (?)";
    $stmt = $conn->prepare($insertOrderSql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id;

        $insertOrderProductSql = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertOrderProductSql);

        foreach ($cartItems as $productId => $quantity) {
            $stmt->bind_param("iii", $orderId, $productId, $quantity);
            if (!$stmt->execute()) {
                $conn->rollback();
                die("Error inserting order products: " . $stmt->error);
            }
        }

        $conn->commit();
        $stmt->close();

        $_SESSION['cart'] = [];

        header("Location: account.php?section=orders");
        exit();
    } else {
        $conn->rollback();
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
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/payment.css">
</head>
<body>
<?php include "navbar.php"; ?>

<img src="../images/sections/payment.png" alt="Payment Page Image" class="section-image"/>
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
<form method="POST" action="payment.php" style="display: flex;">
    <button type="submit" name="purchase" class="button" style="margin: 5em auto;">Purchase</button>
</form>

</body>
</html>
