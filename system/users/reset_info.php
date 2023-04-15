<?php

//error_reporting(0);
require '../info/tips.php';
require_once '../info/check_login.php';
if (ifLogin()){
    exit(str_replace('word',tips(0),"<script>alert('word');window.location='/public/web/login.html'</script>"));
}

function resetSkin(): bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];

    //Path of skins
    $sql = "SELECT skin_path FROM mc_users WHERE account = '$user'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);

    try {
        if (!(unlink($row['skin_path']))){
            $sql = "UPDATE mc_users SET skin_path = null WHERE account = '$user'";
            mysqli_query($conn,$sql);
            mysqli_close($conn);
            die("<script>alert('找不到您的Minecraft皮肤');</script>");
        }
    }
    catch (ArgumentCountError) {
        die('err');
    }

    //Update
    $sql = "UPDATE mc_users SET skin_path = null WHERE account = '$user'";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    if (!($result)){
        die("<script>alert('修改失败');</script>");
    }
    echo "<script>alert('修改成功');</script>";
    return true;
}

function resetPassword(): bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];
    $newPassword = $_POST[ 'resetPassword' ];

    if ($newPassword === ''){
        mysqli_close($conn);
        exit("<script>alert('新密码不应为空');</script>");
    }
    $passAndAccount = $user .$newPassword;

    $passHash = password_hash($passAndAccount,PASSWORD_BCRYPT);
    $sql_update_password = "UPDATE mc_users SET password = '$passHash' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql_update_password);
    mysqli_close($conn);

    if ((!$result)){
        die("<script>alert('修改失败');</script>");
    }

    echo json_encode(array("code"=>1));
    echo "<script>alert('修改成功')</script>";
    return true;
}

function resetCape(): bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];

    $sql_select = "SELECT cape_path FROM mc_users WHERE account = '$user'";
    $result_1 = mysqli_query($conn,$sql_select);
    $row = mysqli_fetch_assoc($result_1);

    if (!(file_exists($row['cape_path']))){
        mysqli_close($conn);
        exit("<script>alert('找不到您的Minecraft披风');</script>");
    }

    unlink($row['cape_path']);

    $sql_update_path = "UPDATE mc_users SET cape_path = null WHERE account = '$user'";
    $result_2 = mysqli_query($conn,$sql_update_path);
    mysqli_close($conn);

    if (!($result_2)){
        die("<script>alert('修改失败');</script>");
    }
    echo "<script>alert('修改成功');</script>";
    return true;
}

$value = $_GET['value'];
require '../conn_sql.php';

if ($value == 1){
    resetSkin();
}
elseif ($value == 2){
    resetCape();
}
elseif ($value == 3){
    resetPassword();
}
else {
    header("HTTP/1.1 500 Internal Server Error");
    header("status: 500 Internal Server Error");
    exit("<script>alert('Something wrong');</script>");
}
