<?php
require_once '../public/function.php';

if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='public/web/login.html'</script>");
}
session_start();

$conn = mysqli_connect("localhost","mu8th1shwn","Nfxk:v6_2Y753S:","mu8th1shwn");
$user = $_SESSION [ 'user' ];//Account

//error_reporting(0);

$newPassword = $_POST[ 'resetPassword' ];
if ($newPassword === ''){
    mysqli_close($conn);
    exit("<script>alert('新密码不应为空');history.go(-1)</script>");
}
$passAndAccount = $user .$newPassword;

$passHash = password_hash($passAndAccount,PASSWORD_BCRYPT);
$sql_update_password = "UPDATE mc_users SET password = '$passHash' WHERE account = '$user'";
$result = mysqli_query($conn,$sql_update_password);

if ($result){
    mysqli_close($conn);
    exit("<script>alert('修改失败');history.go(-1)</script>");
}
echo "<script>alert('修改成功');history.go(-1)</script>";

mysqli_close($conn);