<?php
function check_vowel($letter) {
    $letter = strtolower($letter);
    $vowels = "aeiou";
    $is_vowel = false;
    for ($i = 0; $i < strlen($vowels); $i++) {
        if ($vowels[$i] == $letter) {
            $is_vowel = true;
        }
    }
    return $is_vowel;
}

function count_vowels($string) {
    $counter = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        if (check_vowel($string[$i])) {
            $counter++;
        }
    }
    return $counter;
}

if (isset($_POST["submit"])) {
    $string = $_POST["string"];

    echo count_vowels($string);
}
?>