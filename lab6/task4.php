<?php
function getDigitSum($num) {
    $digitSum = 0;
    while ($num > 0) {
        $digit = $num % 10;
        $num /= 10;
        $digitSum += $digit;
    }
    return $digitSum;
}

echo getDigitSum(10507);
?>
