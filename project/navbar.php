<?php
session_start();
?>

<head>
    <link rel="stylesheet" href="navbar.css">
</head>

<nav class="navbar">
    <ul>
        <li>
            <a href="home.php">
                Home
            </a>
        </li>
        <li>
            <a href="products.php">
                Products
            </a>
        </li>
        <li>
            <a href="cart.php">
                Cart
            </a>
        </li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li>
                <a href="logout.php">
                    Logout
                </a>
            </li>
            <li>
                <a href="account.php">
                    Account
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="login.php">
                    Login
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
