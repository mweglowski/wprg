<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $string = $_POST['string'];
    $operation = $_POST['operation'];
    $result = '';

    if (strlen(trim($string)) == 0) {
        $result = "Empty string.";
    } else {
        switch ($operation) {
            case 'reverse':
                $result = strrev($string);
                break;
            case 'uppercase':
                $result = strtoupper($string);
                break;
            case 'lowercase':
                $result = strtolower($string);
                break;
            case 'length':
                $result = strlen($string);
                break;
            case 'remove-whitespaces':
                $result = trim($string);
                break;
            default:
                $result = "Invalid operation.";
        }
    }

    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Result</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
<div class='result'>
    <p>Result:</p>
    <p>$result</p>
    <br><br>
    <a href='register.php'>Go Back</a>
</div>
</body>
</html>";
}
?>
