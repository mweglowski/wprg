<?php
$filePath = "./links.txt";
$fileHandler = fopen($filePath, "w");

$data = ["https://www.youtube.com/watch?v=B7spmGePXXc&ab_channel=RandomPicks;How to configure PHP interpreter.
", "https://www.youtube.com/watch?v=2xqkSUhmmXU&ab_channel=AlexanderAmini;MIT - Convolutional Neural Networks
", "https://www.youtube.com/watch?v=AhyznRSDjw8&ab_channel=AlexanderAmini;MIT - Deep Reinforcement Learning"];

// Writing to file
foreach ($data as $line) {
    fwrite($fileHandler, $line);
}
fclose($fileHandler);

// Reading file
$fileHandler = fopen($filePath, "r");
$content = fread($fileHandler, filesize($filePath));
$lines = explode("\n", $content);

$counter = 1;
foreach ($lines as $line) {
    $lineData = explode(";", $line);
    $link = $lineData[0];
    $description = $lineData[1];

    echo "ID: $counter\nLink: $link\nDescription: $description\n\n";
    $counter++;
}
?>
