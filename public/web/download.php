<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Download</title>
    <link rel="stylesheet" type="text/css" href="../css/down.css">
    <link rel="shortcut icon" href="../img/ico.webp">
    <style id="display">body{display: none;}</style>
</head>
<body>
<div id="main-box">
    <h1>临时下载页</h1>
    <div class="box">
        <p>test</p>
        <button class="down_button" value="test" onclick="downloadFileOne()">
            test
        </button>
    </div>
    <!--div class="box">
        <p>服务器用客户端</p>
        <button class="down_button" value="mods" onclick="downloadFileTwo()">
            mods
        </button>
    </div>
    <div class="box">
        <p>服务器用客户端</p>
        <button class="down_button">
            <a href="/saveFiles/skins/test.png" download="client.zip">Client-1.2</a>
        </button>
    </div-->
    <div class="box">
        <p>整合包</p>
        <button class="down_button">
            LightMod_pre2
        </button>
    </div>
    <div id="footer">

    </div>
</div>
</body>
<script type="text/javascript">
    function downloadFileOne(){
        let domA = document.createElement('a');
        domA.setAttribute('download','test.png');
        domA.setAttribute('href','/saveFiles/test.png');
        domA.click();
    }
    function downloadFileTwo(){
        let domA = document.createElement('a');
        domA.setAttribute('download','mods.zip');
        domA.setAttribute('href','/saveFiles/mods.zip');
        domA.click();
    }
</script>
</html>
<?php
require_once 'system/info/check_login.php';

if (ifLogin()){
    exit("<script>document.getElementById('display').innerText = 'body{display: inline-block;}'</script>");
}
echo "<script>document.getElementById('display').innerText = 'body{display: none;}'</script>";
?>