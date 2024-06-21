<?php
session_start();

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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT firstName, lastName, email, role, password, createdAt FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $role, $password, $createdAt);
$stmt->fetch();
$stmt->close();

// Determine which section to show
$section = isset($_GET['section']) ? $_GET['section'] : 'accountDetails';

// Fetch user orders
$orders = [];
if ($section == 'orders') {
    $sql = "SELECT orders.id as order_id, orders.created_at, products.title, products.authors, products.price, order_products.quantity 
            FROM orders 
            JOIN order_products ON orders.id = order_products.order_id 
            JOIN products ON order_products.product_id = products.id 
            WHERE orders.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = [
                'created_at' => $row['created_at'],
                'products' => []
            ];
        }
        $orders[$order_id]['products'][] = [
            'title' => $row['title'],
            'authors' => $row['authors'],
            'price' => $row['price'],
            'quantity' => $row['quantity']
        ];
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="account.css">
</head>
<body>
<?php include "navbar.php"; ?>

<div class="section">
    <h2 style="text-align: center; margin: 50px;">Account</h2>

    <div style="border-bottom: 2px solid black; display: flex; justify-content: center; gap: 10px; max-width: 500px; margin: auto; width: 100%;">
        <a href="?section=accountDetails" class="button" style="font-size: 0.85em; text-decoration: none;">Account Details</a>
        <a href="?section=orders" class="button" style="font-size: 0.85em; text-decoration: none;">Orders</a>
    </div>

    <?php if ($section == 'accountDetails') { ?>
        <div class="account-details">
            <h3>Account Details</h3>
            <div class="account-detail">
                <strong>First Name:</strong> <p><?php echo htmlspecialchars($firstName); ?></p>
            </div>
            <div class="account-detail">
                <strong>Last Name:</strong> <p><?php echo htmlspecialchars($lastName); ?></p>
            </div>
            <div class="account-detail">
                <strong>Email:</strong> <p><?php echo htmlspecialchars($email); ?></p>
            </div>
            <div class="account-detail">
                <strong>Password:</strong> <p>xxxxxxxxxx</p>
            </div>
            <div class="account-detail">
                <strong>Created At:</strong> <p><?php echo htmlspecialchars($createdAt); ?></p>
            </div>
        </div>
    <?php } elseif ($section == 'orders') { ?>
        <div class="orders">
            <h3>Orders</h3>
            <?php if (!empty($orders)) { ?>
                <ul class="orders-list">
                    <?php foreach ($orders as $order_id => $order) { ?>
                        <li class="order-card">
                            <strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?><br>
                            <strong>Date:</strong> <?php echo htmlspecialchars($order['created_at']); ?><br>
                            <strong>Products:</strong>
                            <ul class="order-products-list">
                                <?php foreach ($order['products'] as $product) { ?>
                                    <li class="order-product-card">
                                        <strong>Title:</strong> <?php echo htmlspecialchars($product['title']); ?><br>
                                        <strong>Authors:</strong> <?php echo htmlspecialchars($product['authors']); ?><br>
                                        <strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?><br>
                                        <strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity']); ?><br>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>You have no orders.</p>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if ($section === 'accountDetails') { ?>
        <a href="resetPassword.php" class="button" style="font-size: 0.85em; text-decoration: none; margin: 3em auto;">Reset Password</a>
    <?php } ?>
</div>

</body>
</html>
