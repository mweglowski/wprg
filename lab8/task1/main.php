<?php
if (isset($_POST["submit"])) {
    $string = $_POST["string"];

    echo strtoupper($string) . "<br>";
    echo strtolower($string) . "<br>";
    echo ucfirst(strtolower($string)) . "<br>";
    echo ucwords(strtolower($string));
}
?>