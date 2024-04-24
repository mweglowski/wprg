<?php

function generateCustomArray($a, $b, $c, $d) {
    $customArray = array();
    $nextValue = $c;
    for ($i = $a; $i <= $b; $i++) {
        $customArray[$i] = $nextValue;
        $nextValue += 1;
    }
    print_r($customArray);
}

generateCustomArray(5, 10, 7, 12);

?>
