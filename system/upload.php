
<?php
require_once '../public/function.php';
require_once "../public/record.php";

if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='public/web/login.html'</script>");
}

header("content-type:text/html;charset=utf-8");
//error_reporting(0);

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
if ($size > 4096) {
    exit("<script>alert('文件不应大于4096字节');history.go(-1)</script>");
}

//数据库验证
$conn = mysqli_connect("localhost","mu8th1shwn","Nfxk:v6_2Y753S:","mu8th1shwn");

session_start();

//登录及重复上传检查
$user = $_SESSION [ 'user' ];

//$sql = "SELECT * FROM mc_users WHERE account = '$user' AND state = true";
/*
$result = $conn->query($sql);
if ($result->num_rows>0){
    mysqli_close($conn);
    exit("<script>alert('请勿重复上传');history.go(-1)</script>");
}
*/

$sql = "SELECT account = '$user' FROM mc_users WHERE state = true";
$result = mysqli_query($conn,$sql);
$result = mysqli_num_rows($result);
if ($result > 0) {
    mysqli_close($conn);
    exit("<script>alert('请勿重复上传');history.go(-1)</script>");
}

//重名检测
$filepath = '../saveFiles/';
$reName = $_POST['reNameFile'];
$savePath = $filepath . $reName . '.png';

if (file_exists($savePath)){
    mysqli_close($conn);
    exit("<script>alert('名称重复');history.go(-1)</script>");
}
/*
$sql_check_repetition = "SELECT skin_path FROM mc_users WHERE skin_path = '$savePath'";
$result = mysqli_query($conn,$sql_check_repetition);
if ($result){
    mysqli_close($conn);
    exit("<script>alert('名称重复');history.go(-1)</script>");
}*/

//上传
if (!(move_uploaded_file($tmp, $filepath . $imgName))) {
    header("HTTP/1.1 500 Internal Server Error");
    header("status: 500 Internal Server Error");
    mysqli_close($conn);
    exit("<script>alert('上传失败 1');history.go(-1)</script>");
}

//数据库操作
$sql_update_true = "UPDATE mc_users SET state = true WHERE account = '$user'";
$result = mysqli_query($conn,$sql_update_true);
if(!($result)){
    $sql_update_true = "UPDATE mc_users SET state = false WHERE account = '$user'";
    $result = mysqli_query($conn,$sql_update_true);
    mysqli_close($conn);
    unlink($filepath.$imgName);
    exit("<script>alert('上传失败 2');history.go(-1)</script>");
}

//重命名
$imgName = rename( $filepath . $imgName,$filepath . $reName . ".png");
if (!($imgName)) {
    mysqli_close($conn);
    exit("<script>alert('上传失败 3');history.go(-1)</script>");
}

/*
$stmt = $conn->prepare("UPDATE mc_users SET skin_path = '$savePath' WHERE account = '$user'");
$stmt->execute();
$result = $stmt->get_result();
*/
$sql_path = "UPDATE mc_users SET skin_path = '$savePath' WHERE account = '$user'";
$result = mysqli_query($conn,$sql_path);
if(!($result)){
    $sql_path = "UPDATE mc_users SET skin_path = 'NONE' WHERE account = '$user'";
    $result = mysqli_query($conn,$sql_path);
    mysqli_close($conn);
    unlink($filepath.$reName.'.png');
    exit("<script>alert('上传失败 4');history.go(-1)</script>");
}

echo "<script>alert('上传成功');history.go(-1)</script>";

mysqli_close($conn);
