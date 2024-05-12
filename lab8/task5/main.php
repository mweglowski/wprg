<?php
if (isset($_POST["submit"])) {
    $string = $_POST["string"];

    $allow_counting = false;
    $counter = 0;

    for ($i = 0; $i < strlen($string); $i++) {
        if ($allow_counting) {
            $counter++;
        }
        if ($string[$i] == ".") {
            $allow_counting = true;
        }
    }

    echo $counter;
}
?>
