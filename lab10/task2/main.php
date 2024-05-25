<?php
session_start();

$formSubmitted = isset($_COOKIE['formSubmitted']);

if (isset($_POST['submit']) && !$formSubmitted) {
    setcookie('formSubmitted', true, time() + (86400 * 365), "/");

    $favoriteLanguage = $_POST['language'];

    header("Location: main.php");
    exit();
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
<h1>Favorite Language Poll</h1>

<p>
    <?php
    if ($formSubmitted) {
        echo "You have already submitted the form.";
        if (isset($favoriteLanguage)) {
            echo "<br>Your favorite language is: " . htmlspecialchars($favoriteLanguage);
        }
    } else {
        echo "You have not submitted the form yet.";
    }
    ?>
</p>

<?php if (!$formSubmitted): ?>
    <form method="post" class="language-form">
        <label>Choose your favorite language:</label><br><br>
        <input type="radio" name="language" value="PHP"> PHP<br>
        <input type="radio" name="language" value="JavaScript"> JavaScript<br>
        <input type="radio" name="language" value="Python"> Python<br>
        <input type="radio" name="language" value="Java"> Java<br>
        <input type="radio" name="language" value="Ruby"> Ruby<br><br>
        <button type="submit" name="submit">Submit</button>
    </form>
<?php endif; ?>

</body>
</html>
