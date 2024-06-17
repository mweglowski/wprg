<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<nav>
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
            <a href="login.php">
                Login
            </a>
        </li>
    </ul>
</nav>

<h2 style="text-align: center; margin: 50px;">PRODUCTS</h2>

<!-- PRODUCTS LIST -->
<div>
    <ul class="product-card-list">
        <li class="product-card">
            <!-- IMAGE -->
            <img class="product-card-image" src="./images/rl_introduction_book.jpg" alt="Product Image" />
            <!-- TITLE -->
            <div class="product-card-title">Reinforcement Learning: An Introduction</div>
            <!-- AUTHORS -->
            <div class="product-card-authors">Richard Sutton, Andrew Barto</div>
            <!-- DESCRIPTION -->
            <div class="product-card-description">The best Reinforcement Learning book available on the market.</div>
            <!-- ADD TO CART BUTTON & PRICE -->
            <div class="product-card-button-and-price">
                <button class="button">Add to Cart</button>
                <div class="product-card-price">$119.99</div>
            </div>
        </li>
    </ul>
</div>

</body>
</html>
