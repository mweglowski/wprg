<?php
function sum($firstElement, $difference, $elementsQuantity) {
    // ARITHMETIC
    $total_sum = $firstElement;
    $nextElement = $firstElement;
    for ($i = 0; $i < $elementsQuantity - 1; $i++) {
        $nextElement += $difference;
        $total_sum += $nextElement;
    }
    echo "Arithmetic sum: $total_sum\n";

    // GEOMETRIC
    $total_sum = $firstElement;
    $nextElement = $firstElement;
    for ($i = 0; $i < $elementsQuantity - 1; $i++) {
        $nextElement *= $difference;
        $total_sum += $nextElement;
    }
    echo "Geometric sum: $total_sum\n";
}

sum(1, 1, 3);
?>