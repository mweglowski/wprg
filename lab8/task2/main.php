<?php
if (isset($_POST["submit"])) {
    $string = $_POST["string"];

    $forbidden_chars = "\\/:*?\"<>|+-";
    $result_string = "";
    for ($i = 0; $i < strlen($string); $i++) {
        $isForbidden = false;
        for ($j = 0; $j < strlen($forbidden_chars); $j++) {
            if ($string[$i] == $forbidden_chars[$j]) {
                $isForbidden = true;
            }
        }
        if (!$isForbidden) {
            $result_string = $result_string . $string[$i];
        }
    }

    echo $result_string;
}
?>