<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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

    <h2 style="text-align: center; margin: 50px;">LOGIN</h2>

    <form action="" method="post" class="login-form">
        <input class="input"
            type="text" placeholder="Email" />
        <input class="input"s type="password" placeholder="Password" />
        <button type="submit" class="button" style="margin: auto; margin-top: 20px;">Login</button>
    </form>

    <div class="login-register-paragraph">
        Don't have an account? <a href="register.php" >Register</a>
    </div>
</body>
</html>
