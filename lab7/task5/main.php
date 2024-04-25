<?php
// WALIDACJA W PHP WYSTĘPUJE TYLKO W PRZYPADKU
// KALKULATORA ZAAWANSOWANEGO, GDYŻ JEŻELI CHODZI
// O KALKULATOR PROSTY WYSTARCZAJĄCA WALIDACJA
// ZACHODZI JUŻ PO STRONIE HTMLA

function simpleCalculator($num1, $num2, $operation) {
    switch ($operation) {
        case 'Addition':
            return $num1 + $num2;
        case 'Subtraction':
            return $num1 - $num2;
        case 'Multiplication':
            return $num1 * $num2;
        case 'Division':
            return $num1 / $num2;
        default:
            return "Unknown operation";
    }
}

function isBinary($num) {
    for ($i = 0; $i < strlen($num); $i++) {
        if (!($num[$i] == '1' or $num[$i] == '0')) {
            return false;
        }
    }
    return true;
}

//function isLetterInArray($letter, $array) {
//    for ($i = 0; $i < count($array); $i++) {
//        if ($array[$i] == $letter) {
//            return true;
//        }
//    }
//    return false;
//}

//function isHexadecimal($num) {
//    if (!(strlen($num) == 3 or strlen($num) == 6)) {
//        return false;
//    }
//
//    $validCharacters = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "a", "B", "b", "C", "c", "D", "d", "E", "e", "F", "f"];
//
//
//    for ($i = 0; $i < strlen($num); $i++) {
//        if (!isLetterInArray($num[$i], $validCharacters)) {
//            return false;
//        }
//    }
//    return true;
//}

function advancedCalculator($num, $operation) {
    switch ($operation) {
        case 'cos':
            if (!is_numeric($num)) {
                return "Enter valid decimal number";
            }
            return cos($num);
        case 'sin':
            if (!is_numeric($num)) {
                return "Enter valid decimal number";
            }
            return sin($num);
        case 'tan':
            if (!is_numeric($num)) {
                return "Enter valid decimal number";
            }
            return tan($num);
        case 'bin to dec':
            if (!isBinary($num)) {
                return "Enter valid binary number";
            }
            return bindec($num);
        case 'dec to bin':
            if (!ctype_digit($num)) {
                return "Enter valid decimal number";
            }
            return decbin($num);
        case 'dec to hex':
            if (!ctype_digit($num)) {
                return "Enter valid decimal number";
            }
            return dechex($num);
        case 'hex to dec':
            if (!ctype_xdigit($num)) {
                return "Enter valid hex number";
            }
            return hexdec($num);
        default:
            return "Unknown operation";
    }
}

if (isset($_POST["simple-calculator"])) {
    $num1 = floatval($_POST["simple-number-1"]);
    $num2 = floatval($_POST["simple-number-2"]);
    $operation = $_POST["simple-operation"];

    echo simpleCalculator($num1, $num2, $operation);
}

if (isset($_POST["advanced-calculator"])) {
    $num = $_POST["advanced-number"];
    $operation = $_POST["advanced-operation"];

    echo advancedCalculator($num, $operation);
}

?>