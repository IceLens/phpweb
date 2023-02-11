<?php
session_start();

unset($_SESSION['user']);        //用户退出
header('Location:index.php');
