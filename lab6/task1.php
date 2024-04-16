<?php
function checkPrime($num) {
    if ($num < 2) return false;
    for ($i = 2; $i < $num; $i++) {
        if ($num % 2 == 0) {
            return false;
        }
    }
    return true;
}
function printPrimes($a, $b) {
    for ($i = $a; $i <= $b; $i++) {
        if (checkPrime($i)) {
            echo "$i\n";
        }
    }
}

printPrimes(2,14);
?>