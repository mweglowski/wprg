<?php
session_start();

if (isset($_POST['logout'])) {
    echo "Session before unset: ";
    print_r($_SESSION); // Debugging: Print session before unset
    session_unset();
    echo "Session after unset: ";
    print_r($_SESSION); // Debugging: Print session after unset
    session_destroy();
    header("Location: products.php");
    exit();
}

if (isset($_POST['cancel'])) {
    header("Location: home.php"); // Redirect to home or any other page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="logout.css">
</head>
<body>
<?php
include "navbar.php";
?>

<h2 style="text-align: center; margin: 50px;">Are you sure you want to log out?</h2>

<form action="logout.php" method="post" style="text-align: center; margin: 50px;">
    <div class="logout-control-buttons-container">
        <button type="submit" name="cancel" class="button">Cancel</button>
        <button type="submit" name="logout" class="button">Logout</button>
    </div>
</form>

</body>
</html>
