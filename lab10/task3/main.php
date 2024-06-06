<?php
session_start();

$validLogin = "marcin";
$validPassword = "password";

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'back') {
    $error = "none";
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($login == $validLogin && $password == $validPassword) {
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['userLogin'] = $login;
        header("Location: index.php");
        exit();
    } else {
        $error = "Wrong login or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Language Poll</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Login Form</h1>

<?php if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']): ?>

    <p class="message">Welcome, <?php echo $_SESSION['userLogin']; ?>! You are logged in.</p>
    <a href="?action=logout">Logout</a>

<?php else: ?>

    <?php if (isset($error) && $error != "none"): ?>
        <p class="message" style="color: red;"><?php echo $error; ?></p>
        <a href="?action=back">Back</a>
    <?php else: ?>
    <form method="post">
        <label for="login">Login</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="submit">Login</button>
    </form>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>
