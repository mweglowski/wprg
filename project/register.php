<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

<h2 style="text-align: center; margin: 50px;">REGISTER</h2>

<form action="" method="post" class="login-form">
    <input class="input" type="text" placeholder="First Name" />
    <input class="input" type="text" placeholder="Last Name" />
    <input class="input"
           type="text" placeholder="Email" />
    <input class="input" type="password" placeholder="Password" />
    <button type="submit" class="button" style="margin: auto; margin-top: 20px;">Register</button>
</form>

<div class="login-register-paragraph">
    Already have an account? <a href="login.php" >Login</a>
</div>
</body>
</html>
