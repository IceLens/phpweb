<?php
header("content-type:text/html;charset=utf-8");
//error_reporting(0);
require_once '../public/function.php';

if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='/public/web/login.html'</script>");
}

function upLoad($savePath) : string
{
    global $tmp,$imgName;
    $newName = $_POST['reNameFile'];
    $filePath = $savePath . $newName . '.png';

    if (file_exists($filePath)){
        die("<script>alert('名称重复');history.go(-1)</script>");
    }
    if (!(move_uploaded_file($tmp, $savePath . $imgName))) {
        die("<script>alert('上传失败 1');history.go(-1)</script>");
    }
    $reName = rename( $savePath . $imgName,$savePath . $newName . ".png");
    if (!($reName)) {
        die("<script>alert('上传失败 3');history.go(-1)</script>");
    }
    return $newName;
}

function updateSkin($user) : bool
{
    global $conn;
    $sql = "SELECT account = $user FROM mc_users WHERE skin_path IS NULL";
    $result = mysqli_query($conn,$sql);
    if (!($result)){
        mysqli_close($conn);
        exit("<script>alert('请勿重复上传')</script>");
    }
    $savePath = '../saveFiles/skins'; //线上为 '/server/skins'
    $newName = upLoad($savePath);

    $sql = "UPDATE mc_users SET skin_path = '$savePath' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        $sql = "UPDATE mc_users SET skin_path = 'NONE' WHERE account = '$user'";
        mysqli_query($conn,$sql);
        unlink($savePath.$newName.'.png');
        mysqli_close($conn);
        die("<script>alert('上传失败 4');history.go(-1)</script>");
    }
    echo "<script>alert('上传成功');history.go(-1)</script>";
    return true;
}

function upLoadCape($user) : bool
{
    global $conn;
    $sql = "SELECT account = '$user' FROM mc_users WHERE mc_users.cape_path IS NULL";
    $result = mysqli_query($conn,$sql);
    if (!($result)){
        mysqli_close($conn);
        exit("<script>alert('请勿重复上传')</script>");
    }
    $savePath = '../saveFiles/capes'; //线上为 '/server/skins'
    $newName = upLoad($savePath);

    $sql = "UPDATE mc_users SET cape_path = '$savePath' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql);
    if(!($result)){
        $sql = "UPDATE mc_users SET cape_path = 'NONE' WHERE account = '$user'";
        mysqli_query($conn,$sql);
        unlink($savePath.$newName.'.png');
        mysqli_close($conn);
        die("<script>alert('上传失败 4');history.go(-1)</script>");
    }
    echo "<script>alert('上传成功');history.go(-1)</script>";
    return true;
}


//验证合法
$imgName = $_FILES['myFile']['name'];
$tmp = $_FILES['myFile']['tmp_name'];

$size = filesize($tmp);
$file = fopen($tmp, 'rb');
$bin  = fread($file, 2); //只读2字节

fclose($file);
$strInfo  = @unpack('C2chars', $bin);
$typeCode = intval($strInfo['chars1'].$strInfo['chars2']);

$fileType = '';

if ($typeCode != "13780"){
    exit("<script>alert('只能上传PNG格式的图片');history.go(-1)</script>");
}
if ($size > 20480) {
    exit("<script>alert('文件不应大于20KB');history.go(-1)</script>");
}

require './conn_sql.php';
$user = $_SESSION [ 'user' ];
$imgSize = getimagesize($tmp);

if (in_array("64",$imgSize)){
    updateSkin($user);
}
elseif (in_array("512",$imgSize)){
    upLoadCape($user);
}
else {
    die("<script>alert('你要不看看你上传的是什么');history.go(-1)</script>");
}