<?php

//error_reporting(0);
require_once '../public/function.php';
if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='/public/web/login.html'</script>");
}

require './conn_sql.php';

function resetSkin(): bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];

    //Path of skins
    $sql_select = "SELECT skin_path FROM mc_users WHERE account = '$user'";
    $result_1 = mysqli_query($conn,$sql_select);
    $row = mysqli_fetch_assoc($result_1);

    if (!(file_exists($row['skin_path']))){
        mysqli_close($conn);
        exit("<script>alert('找不到您的Minecraft皮肤');history.go(-1)</script>");
    }

    unlink($row['skin_path']);

    //Update
    $sql_update_path = "UPDATE mc_users SET skin_path = null WHERE account = '$user'";
    $result_2 = mysqli_query($conn,$sql_update_path);
    mysqli_close($conn);

    if (!($result_2)){
        die("<script>alert('修改失败');history.go(-1)</script>");
    }
    echo "<script>alert('修改成功');history.go(-1)</script>";
    return true;
}

function resetPassword(): bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];
    $newPassword = $_POST[ 'resetPassword' ];

    if ($newPassword === ''){
        mysqli_close($conn);
        exit("<script>alert('新密码不应为空');history.go(-1)</script>");
    }
    $passAndAccount = $user .$newPassword;

    $passHash = password_hash($passAndAccount,PASSWORD_BCRYPT);
    $sql_update_password = "UPDATE mc_users SET password = '$passHash' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql_update_password);
    mysqli_close($conn);

    if ((!$result)){
        die("<script>alert('修改失败');history.go(-1)</script>");
    }
    echo "<script>alert('修改成功');history.go(-1)</script>";
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
        exit("<script>alert('找不到您的Minecraft披风');history.go(-1)</script>");
    }

    unlink($row['cape_path']);

    $sql_update_path = "UPDATE mc_users SET cape_path = null WHERE account = '$user'";
    $result_2 = mysqli_query($conn,$sql_update_path);
    mysqli_close($conn);

    if (!($result_2)){
        die("<script>alert('修改失败');history.go(-1)</script>");
    }
    echo "<script>alert('修改成功');history.go(-1)</script>";
    return true;
}

//TODO 分辨类型
if ($_POST['resetSkin'] == '重置皮肤'){
    resetSkin();
}
elseif ($_POST['resetPassword'] !== '') {
    resetPassword();
}
elseif ($_POST['resetCape'] == '重置披风'){
    resetCape();
}
else {
    header("HTTP/1.1 500 Internal Server Error");
    header("status: 500 Internal Server Error");
}