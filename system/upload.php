<?php
header("content-type:text/html;charset=utf-8");
//error_reporting(0);
require_once '../public/function.php';

if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='/public/web/login.html'</script>");
}

function checkThanUpload($tmp,$fileSize,$type) : void
{
    if (!(is_file($tmp))){
        exit("<script>alert('文件不能为空');</script>");
    }
    //验证合法
    $size = filesize($tmp);
    $file = fopen($tmp, 'rb');
    $bin  = fread($file, 2); //只读2字节

    fclose($file);
    $strInfo  = @unpack('C2chars', $bin);
    $typeCode = intval($strInfo['chars1'].$strInfo['chars2']);

    $fileType = '';

    if ($typeCode != "13780"){
        exit("<script>alert('只能上传PNG格式的图片');</script>");
    }
    if ($size > $fileSize) {
        exit("<script>alert('文件不应大于2048字节');</script>");
    }
/*
    $imgSize = getimagesize($tmp);
    if (in_array("64",$imgSize)){
        updateSkin();
    }
    elseif (in_array("512",$imgSize)) {
        upLoadCape();
    }*/
    if ($type === 1){
        uploadSkin();
    }
    elseif ($type === 2){
        upLoadCape();
    }
    else {
        die("<script>alert('你要不看看你上传的是什么');</script>");
    }
}

function upLoad($imgName,$tmp,$savePath) : string
{
    $newName = $_POST['reNameFile'];
    $filePath = $savePath . $newName . '.png';

    if (file_exists($filePath)){
        die("<script>alert('名称重复');</script>");
    }
    if (!(move_uploaded_file($tmp, $savePath . $imgName))) {
        die("<script>alert('上传失败 1');</script>");
    }
    $reName = rename( $savePath . $imgName,$savePath . $newName . ".png");
    if (!($reName)) {
        die("<script>alert('上传失败 3');</script>");
    }
    return $savePath . $newName . ".png";
}

function uploadSkin() : bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];
    $tmp = $_FILES['mySkin']['tmp_name'];
    $imgName = $_FILES['mySkin']['name'];

     $imgSize = getimagesize($tmp);
    if (!(in_array("64",$imgSize))){
        exit("<script>alert('图片应为64*64像素');</script>");
    }

    $sql = "SELECT account = '$user' FROM mc_users WHERE skin_path IS NOT NULL";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)>0){
        mysqli_close($conn);
        exit("<script>alert('请勿重复上传');</script>");
    }

    $savePath = '../saveFiles/skins/';
    $newName = upLoad($imgName,$tmp,$savePath);

    $sql = "UPDATE mc_users SET skin_path = '$newName' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        $sql = "UPDATE mc_users SET skin_path = null WHERE account = '$user'";
        mysqli_query($conn,$sql);
        unlink($savePath.$newName.'.png');
        mysqli_close($conn);
        die("<script>alert('上传失败 4');</script>");
    }
    echo "<script>alert('上传成功');p</script>";
    return true;
}


function upLoadCape() : bool
{
    global $conn;
    $user = $_SESSION [ 'user' ];
    $tmp = $_FILES['myCape']['tmp_name'];
    $imgName = $_FILES['myCape']['name'];

    $imgSize = getimagesize($tmp);
    if (!(in_array("512",$imgSize))){
        exit("<script>alert('图片因为512*256像素');p</script>");
    }

    $sql = "SELECT account = '$user' FROM mc_users WHERE mc_users.cape_path IS NOT NULL";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)>0){
        mysqli_close($conn);
        exit("<script>alert('请勿重复上传');p</script>");
    }

    $savePath = '../saveFiles/capes'; //线上为 '/server/skins'
    $newName = upLoad($imgName,$tmp,$savePath);

    $sql = "UPDATE mc_users SET cape_path = '$newName' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        $sql = "UPDATE mc_users SET cape_path = null WHERE account = '$user'";
        mysqli_query($conn,$sql);
        unlink($savePath.$newName.'.png');
        mysqli_close($conn);
        die("<script>alert('上传失败 4');p</script>");
    }
    echo "<script>alert('上传成功');</script>";
    return true;
}

$value = $_GET['value'];
require './conn_sql.php';

if ($value == 1){
    $tmp = $_FILES['mySkin']['tmp_name'];
    checkThanUpload($tmp,2048,1);
}
elseif ($value == 2){
    $tmp = $_FILES['myCape']['tmp_name'];
    checkThanUpload($tmp,20480,2);
}
else {
    header("HTTP/1.1 500 Internal Server Error");
    header("status: 500 Internal Server Error");
    exit("<script>alert('你要不看看你上传的是什么');</script>");
}

