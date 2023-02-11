<?php

//error_reporting(0);

$conn = mysqli_connect("localhost","mu8th1shwn","Nfxk:v6_2Y753S:","mu8th1shwn");

//err
mysqli_query($conn,'set names utf8');
mysqli_query($conn,'set character set utf8');
if(mysqli_connect_error()){
    $myFile = fopen('../log.txt', "w+") or die("Unable to open file!");
    $err = mysqli_connect_error();
    fwrite($myFile, $err);
    fclose($myFile);
    die("connect error");
}

session_start();