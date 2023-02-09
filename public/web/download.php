<-?php
require_once '../function.php';

if (!(ifLogin())){
    exit("<script>alert('请登录在浏览哦');window.location='public/web/login.html'</script>");
}
?->
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Download</title>
    <link rel="stylesheet" type="text/css" href="../css/down.css">
    <link rel="shortcut icon" href="../img/ico.webp">
</head>
<body>
<div id="main-box">
    <h1>临时下载页</h1>
    <div class="box">
        <p>test</p>
        <button class="down_button" value="test" onclick="downloadFileOne()">
            <p>test</p>
        </button>
    </div>
    <div class="box">
        <p>服务器用客户端</p>
        <button class="down_button" value="mods" onclick="downloadFileTwo()">
            <p>mods</p>
        </button>
    </div>
    <div class="box">
        <p>服务器用客户端</p>
        <button class="down_button">
            <a href="/saveFiles/mods.zip" download="client.zip">Client-1.2</a>
        </button>
    </div>
    <div class="box">
        <p>整合包</p>
        <button class="down_button">
            <p>Lightmod_pre2</p>
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