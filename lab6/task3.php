<?php
function multiplyMatrices($a, $b) {
    $newMatrice = [];

    for ($i = 0; $i < count($a); $i++) {
        $newMatriceRow = [];
        for ($k = 0; $k < count($b[0]); $k++) {
            $cellSum = 0;
            for ($j = 0; $j < count($b); $j++) {
                $cellSum += $a[$i][$j] * $b[$j][$k];
            }
            $newMatriceRow[$k] = $cellSum;
            echo $newMatriceRow[$k];
            echo " ";
        }
        $newMatrice[$i] = $newMatriceRow;
        echo "\n";
    }
}

multiplyMatrices([[1, 5, 10], [3, 3, 1], [1, 3, 4]], [[3, 1], [2, 1], [1, 0]]);

?>
