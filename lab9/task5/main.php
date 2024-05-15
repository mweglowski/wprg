<?php
$userIp = $_SERVER['REMOTE_ADDR'];

$allowedIpFilePath = './allowed_ips.txt';

$fileHandler = fopen($allowedIpFilePath, 'r');
$content = fread($fileHandler, filesize($allowedIpFilePath));
$allowedIpsArray = explode("\n", $content);

$isUserAllowed = false;

foreach ($allowedIpsArray as $allowedIp) {
    if ($allowedIp === $userIp) {
        $isUserAllowed = true;
        break;
    }
}

if ($isUserAllowed) {
    include 'allowed_page.php';
} else {
    include 'default_page.php';
}
?>
