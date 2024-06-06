<?php
session_start();

if (!isset($_COOKIE['visitCount'])) {
    $visitCount = 0;
} else {
    $visitCount = $_COOKIE['visitCount'];
}

$visitCount++;

setcookie('visitCount', $visitCount, time() + (86400 * 365), "/"); // 86400 = 1 day

if (isset($_POST['reset'])) {
    setcookie('visitCount', 0, time() + (86400 * 365), "/");
    $visitCount = 0;
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Counter</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Visit Counter</h1>
<p>Number of visits: <?php echo $visitCount; ?></p>

<p>
    <?php
    if ($visitCount >= 3) {
        echo "There is no secret info!";
    } else {
        echo "Visit page again to see secret info!";
    }
    ?>
</p>

<form method="post">
    <button type="submit" name="reset">Reset Counter</button>
</form>

</body>
</html>
