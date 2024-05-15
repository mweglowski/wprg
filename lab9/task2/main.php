<?php

function isDirectoryEmpty($dir) {
    $files = scandir($dir);
    $files = array_diff($files, array('.', '..'));
    return empty($files);
}

function handleFileOperation($path, $dir, $operation) {
    // Checking if path exists
    if (file_exists($path)) {
        $pathToDir = $path . $dir;
        if (!file_exists($pathToDir) && $operation == "delete") {
            echo "Directory does not exist";
            return;
        }

        if ($operation == "read") {
            if (!file_exists($pathToDir)) {
                echo "Directory does not exist.";
                exit();
            }

            if (isDirectoryEmpty($pathToDir)) {
                echo "Directory is empty.";
                return;
            }

            // Reading all files in directory
            $files = scandir($pathToDir);

            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    echo $file . "<br>";
                }
            }
        } elseif ($operation == "create") {
            if (empty($dir)) {
                echo "Could not create directory with empty name.";
                return;
            }

            if (file_exists($pathToDir)) {
                echo "Directory already exists.";
                return;
            }

            // Creating new directory
            mkdir($pathToDir, 0777, true);
            echo "Directory created.";
        } else {
            if (!file_exists($pathToDir)) {
                echo "Directory does not exist.";
            }

            // Deleting directory
            // Check if dir is empty before deletion
            if (!isDirectoryEmpty($pathToDir)) {
                echo "Directory is not empty.";
            } else {
                rmdir($pathToDir);
                echo "Directory removed.";
            }
        }
    } else {
        echo "Invalid directory.";
    }
}

if (isset($_GET["submit"])) {
    $path = $_GET["path"];
    $dir = $_GET["dir"];
    $operation = $_GET["operation"];

    handleFileOperation($path, $dir, $operation);
}
?>
