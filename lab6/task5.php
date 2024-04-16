<?php
function isTextPangram($text) {
    $letters = [];
    for ($i = 0; $i < strlen($text); $i++) {
        $letter = strtolower($text[$i]);
        if (ctype_alpha($letter)) {
            if (isset($letters[$letter])) {
                $letters[$letter]++;
            } else {
                $letters[$letter] = 1;
            }
        }
    }

    if (count($letters) == 26) {
        return "true";
    }
    return "false";
}

echo isTextPangram("The quick brown fox jumps over the lazy dog.");
?>
