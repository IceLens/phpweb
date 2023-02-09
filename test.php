
<?php

$conn = mysqli_connect("localhost","mu8th1shwn","Nfxk:v6_2Y753S:","mu8th1shwn");
/*
$sql = "SELECT password FROM mc_users WHERE account = '123456'";
$result = mysqli_query($conn, $sql);
*/
$stmt = $conn->prepare("SELECT password FROM mc_users WHERE account = '123456'");
$stmt->execute();
$result = $stmt->num_rows();

print $result;

/*
if (mysqli_num_rows($result) == 0){
    mysqli_close($conn);
    echo "<script> alert('登录失败');history.go(-1)</script>";
    exit();
}
*/















