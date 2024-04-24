<?php
$array = array("Italy"=>"Rome",
    "Luxembourg"=>"Luxembourg",
    "Belgium"=> "Brussels",
    "Denmark"=>"Copenhagen",
    "Finland"=>"Helsinki",
    "France" => "Paris",
    "Slovakia"=>"Bratislava",
    "Slovenia"=>"Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland"=>"Dublin",
    "Netherlands"=>"Amsterdam",
    "Portugal"=>"Lisbon",
    "Spain"=>"Madrid",
    "Sweden"=>"Stockholm",
    "United Kingdom"=>"London",
    "Cyprus"=>"Nicosia",
    "Lithuania"=>"Vilnius",
    "Czech Republic"=>"Prague",
    "Estonia"=>"Tallin",
    "Hungary"=>"Budapest",
    "Latvia"=>"Riga","Malta"=>"Valetta",
    "Austria" => "Vienna",
    "Poland"=>"Warsaw");

//for ($i = 0; $i < count($array); $i++) {
//    for ($j = 0; $j < count($array); $j++) {
//        if ($array[])
//    }
//}
asort($array);

$arrayLength = count($array);
$arrayKeys = array_keys($array);

for ($i = 0; $i < $arrayLength - 1; $i++) {
    for ($j = 0; $j < $arrayLength - 1; $j++) {
        if ($array[$arrayKeys[$j]] > $array[$arrayKeys[$j + 1]]) {
            $temp = $array[$arrayKeys[$j]];
            $array[$arrayKeys[$j]] = $array[$arrayKeys[$j + 1]];
            $array[$arrayKeys[$j]] = $temp;
        }
    }
}

for ($i = 0; $i < $arrayLength; $i++) {
    $nextLine = "The capital of " . $arrayKeys[$i] . " is " . $array[$arrayKeys[$i]] . "\n";
    echo $nextLine;
}
?>
