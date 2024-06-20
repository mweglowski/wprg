<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

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

// Handle remove from cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $productIdToRemove = $_POST['remove_product_id'];
    if (isset($_SESSION['cart'][$productIdToRemove])) {
        if ($_SESSION['cart'][$productIdToRemove] > 1) {
            $_SESSION['cart'][$productIdToRemove]--;
        } else {
            unset($_SESSION['cart'][$productIdToRemove]);
        }
    }
}

// Fetch products in the cart
$cartItems = $_SESSION['cart'];
$productIds = array_keys($cartItems);
$totalPrice = 0;

if (!empty($productIds)) {
    $productIdsString = implode(",", array_map('intval', $productIds));
    $sql = "SELECT id, title, authors, price, image FROM products WHERE id IN ($productIdsString)";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productId = $row["id"];
            $totalPrice += $row["price"] * $cartItems[$productId];
        }
    } else {
        $result = false;
    }
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
<?php include "navbar.php"; ?>

<h2 style="text-align: center; margin: 50px;">Cart</h2>

<div>
    <ul class="cart-product-list">
        <?php if ($result && $result->num_rows > 0) : ?>
            <?php $result->data_seek(0); ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <?php $productId = $row["id"]; ?>
                <li class="cart-product-item">
                    <img src="<?= $row["image"] ?>" alt="Product Image" class="cart-product-image"/>
                    <div class="cart-product-item-details">
                        <div class="cart-product-item-title"><?= $row["title"] ?></div>
                        <div class="cart-product-item-authors"><?= $row["authors"] ?></div>
                        <div class="cart-product-item-quantity">Quantity: <?= $cartItems[$productId] ?></div>
                        <div class="cart-product-item-price">Price: $<?= $row["price"] * $cartItems[$productId] ?></div>
                    </div>
                    <form method="POST" action="" class="cart-product-remove-form">
                        <input type="hidden" name="remove_product_id" value="<?= $productId ?>">
                        <button type="submit" class="button-remove">Remove</button>
                    </form>
                </li>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </ul>

    <?php if ($totalPrice > 0) : ?>
        <div class="cart-total-price">
            <div>Total Price:</div>
            <div>$<?= $totalPrice ?></div>
        </div>
    <?php endif; ?>
</div>

<?php if ($result && $result->num_rows > 0) : ?>
    <h2 style="text-align: center; margin: 50px;">Address</h2>

    <form action="payment.php" method="post" class="login-form">
        <input class="input" type="text" name="city" placeholder="City" required />
        <input class="input" type="text" name="postal_code" placeholder="Postal Code" required />
        <input class="input" type="text" name="street" placeholder="Street" required />
        <input class="input" type="number" name="flat_number" placeholder="Flat Number" required />
        <input class="input" type="text" name="phone_number" placeholder="Phone Number" required />

        <button type="submit" class="button" style="margin: 20px auto; margin-bottom: 100px;" name="apply_address">Go to Payment</button>
    </form>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
