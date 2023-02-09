<?php

//error_reporting(0);

$ip = $_SERVER["REMOTE_ADDR"];

$file = 'E:\Documents\SSH\Website_for_Minecraft_Server\log.txt';
$myFile = fopen($file, "w+") or die("Unable to open file!");
fwrite($myFile, $ip);
fclose($myFile);

