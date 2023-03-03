<?php

header("content-type:text/html;charset=utf-8");

//error_reporting(0);
require './conn_sql.php';
global $conn;

$account = $_POST['account'];
$password = $_POST['password'];

if ($account === '' || $password === ''){
    mysqli_close($conn);
    $result = array("code"=>0);
    exit(json_encode($result));
}

//重名监测
$sql = "SELECT account FROM mc_users WHERE account = '$account'";
$result = mysqli_query($conn,$sql);

$num = mysqli_num_rows($result);
if ($num == 0) {
    mysqli_close($conn);
    $result = array("code"=>1);
    exit(json_encode($result));
}

$passAndAccount = $account .$password;

$sql = "SELECT password FROM mc_users WHERE account = '$account'";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);
if (!(password_verify($passAndAccount,$row['password']))){
    mysqli_close($conn);
    $result = array("code"=>2);
    exit(json_encode($result));
}

$_SESSION['user']=$account;

$data = array();
$data["web"] = './index.html?user=';
$data["user"] = $account;
$result = array("code"=>3,"data"=>$data);
echo json_encode($result);
//header("Location: https://yxclientsyc.chayidc.cn/public/web/user_info.html?user=$user");

mysqli_close($conn);

