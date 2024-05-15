<?php
if (isset($_POST["submit"])) {
    $filePath = "./counter.txt";

    if (file_exists($filePath)) {
        // Increment counter
        $fileHandler = fopen($filePath, "r");
        $counterValue = intval(fread($fileHandler, filesize($filePath)));
        $counterValue++;
        fclose($fileHandler);

        $fileHandler = fopen($filePath, "w");
        fwrite($fileHandler, $counterValue);
        fclose($fileHandler);

        echo "Current counter value: " . $counterValue;
    } else {
        // Create such file and set counter to 1
        $fileHandler = fopen($filePath, "w");
        fwrite($fileHandler, "1");
        fclose($fileHandler);

        echo "File created successfully.<br>Counter set to 1.";
    }
}
?>
