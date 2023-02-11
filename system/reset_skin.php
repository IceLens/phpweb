<?php
require_once '../public/function.php';

if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='/public/web/login.html'</script>");
}

require './conn_sql.php';
global $conn;
//session_start();

//$conn = mysqli_connect("localhost","mu8th1shwn","Nfxk:v6_2Y753S:","mu8th1shwn");
$user = $_SESSION [ 'user' ];//Account

//error_reporting(0);

//Path of skins
$sql_select = "SELECT skin_path FROM mc_users WHERE account = '$user'";
$result_1 = mysqli_query($conn,$sql_select);
$row = mysqli_fetch_assoc($result_1);

if (!(file_exists($row['skin_path']))){
    mysqli_close($conn);
    exit( "<script>alert('找不到您的Minecraft皮肤文件');history.go(-1)</script>");
}

unlink($row['skin_path']);

//Update
$sql_update_true = "UPDATE mc_users SET state = false WHERE account = '$user'";
$result_2 = mysqli_query($conn,$sql_update_true);
$sql_update_path = "UPDATE mc_users SET skin_path = 'NONE' WHERE account = '$user'";
$result_3 = mysqli_query($conn,$sql_update_path);

if (!($result_2 && $result_3)){
    mysqli_close($conn);
    exit("<script>alert('修改失败');history.go(-1)</script>");
}
echo "<script>alert('修改成功');history.go(-1)</script>";

mysqli_close($conn);


