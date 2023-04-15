<?php
header("content-type:text/html;charset=utf-8");
//error_reporting(0);
/*
require_once '../system/info/check_login.php';
require '../system/info/tips.php';
if (ifLogin()){
    exit(str_replace('word',tips(0),"<script>alert('word');window.location='/public/web/login.html'</script>"));
}
*/

function down($file_name) :void
{
    $dir = "saveFiles/";
    $down_host = $_SERVER['HTTP_HOST'];

    if (file_exists(__DIR__ . '/'. $dir . $file_name)){
        header('location: http://'. $down_host. $dir. $file_name);
    }
    else{
        header('HTTP/1.1 404 Not Found');
    }
}

$value = $_GET['file'];
echo $value;

if ($value == 0){
    down('12.txt');
}
elseif ($value == 1){
    down('test.png');
}
else{
    echo "<script>alert('Err')</script>";
}
