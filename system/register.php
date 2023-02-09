
<?php

header("content-type:text/html;charset=utf-8");

//error_reporting(0);

//接收$_POST用户名和密码
$account=$_POST['account'];
$password=$_POST['password'];
$code = $_POST['code'];

if($account === "" || $password === ""){
    $result = array("code"=>0);
    exit(json_encode($result));
}

$conn = new mysqli("localhost","mu8th1shwn","Nfxk:v6_2Y753S:","mu8th1shwn");
/*
$stmt = $conn->prepare("SELECT Invite_Code FROM qq_account_code WHERE QQ_Account = '$account'");
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);
*/
$sql = "SELECT Invite_Code FROM qq_account_code WHERE QQ_Account = '$account'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!(password_verify($code,$row['Invite_Code']))){
    mysqli_close($conn);
    $result = array("code"=>1);
    exit(json_encode($result));
}

//查看表user用户名是否存在
$sql = "SELECT account FROM mc_users WHERE account = '$account'";
$result = mysqli_query($conn,$sql);

$res = mysqli_num_rows($result);
if($res>0){
    mysqli_close($conn);
    $result = array("code"=>2);
    exit(json_encode($result));
}

$passAndAccount = $account .$password;

//写入注册数据
$passHash = password_hash($passAndAccount,PASSWORD_BCRYPT);
$sql="insert into mc_users(account, password, state,skin_path) VALUES ('$account','$passHash',false,'NONE')";
$result = mysqli_query($conn,$sql);
if(!($result)){
    $result = array("code"=>3);
    exit(json_encode($result));
}

$result = array("code"=>4);
echo json_encode($result);

mysqli_close($conn);