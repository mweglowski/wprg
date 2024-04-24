<?php

function insert($array, $n) {
    if ($n > count($array) or $n < 1) {
        echo "ERROR";
        return;

    }

    $newArray = [];
    for ($i = 0; $i < count($array); $i++) {
        if ($i == $n - 1) {
            array_push($newArray, "$", $array[$i]);
        } else {
            array_push($newArray, $array[$i]);
        }
    }

    print_r($newArray);
}

insert([1, 2, 3, 4], 3);

?>
