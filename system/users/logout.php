<?php
header('Content-type:text/html;charset=utf-8');
session_start();

unset($_SESSION['user']);//用户退出
session_destroy();

setcookie('account','',time(),-999);

header('Location:index.php');
