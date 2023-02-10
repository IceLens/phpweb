//密码初次校验
function checkRegPassword() {
    let rePasswordArea = document.getElementById("rePassword");

    let passwordValue = document.getElementById("password").value;
    let rePasswordValue = document.getElementById("rePassword").value;

    if (passwordValue.length<6||passwordValue.length>20) {
        document.getElementById('alert').style.display='block';
        document.getElementById('alert').value='密码长度应为6-20位';
        //alert("密码长度应为6-20位")
        document.getElementById("password").value = "";
        rePasswordArea.value = "";
        return false;
    }

    if (passwordValue !== rePasswordValue) {
        alert("输入的密码不一致")
        rePasswordArea.value = "";
        return false;
    }
    return true;
}

//密码强度
function checkStrong() {
    const password = document.getElementById("password").value;
    let pattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-={}|:"<>?,./;'`~\[\]\\])[A-Za-z\d!@#$%^&*()_+\-={}|:"<>?,./;`~'\[\]\\]{6,20}$/;
     if (pattern.test(password)){
         return true
     }
     else {
         document.getElementById('alert').style.display='block';
         document.getElementById('alert').value='密码强度较低';
         //alert("密码强度较低");
         return false
     }
}

//QQ号检查
function checkAccount() {
    let accountValue  = document.getElementById("account").value;
    let pattern = /[1-9][0-9]{4,}/;

    if (pattern.test(accountValue)){
        return true
    }
    else {
        document.getElementById('alert').style.display='block';
        document.getElementById('alert').value='账号格式错误';
        return false;
    }
}

//GET 用户名
function getPar(par){

    const local_url = document.location.href;
    const get = local_url.indexOf(par + "=");
    if(get === -1){
        return;
    }
    let get_par = local_url.slice(par.length + get + 1);

    const nextPar = get_par.indexOf("&");
    if(nextPar !== -1){
        get_par = get_par.slice(0, nextPar);
    }
    return get_par;
}

//向后端发送
function postInfo(account,password,url,inviteCode) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (!(xhr.readyState === 4)) {
            return;
        }
        if (inviteCode == null){
            let result = JSON.parse(this.responseText);
            callBackCodeLogin(result);
            return;
        }
        let result = JSON.parse(this.responseText);
        callBackCodeReg(result);
    }
    xhr.open("post", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("account="+ account + "&password="+ password + "&code="+ inviteCode);
}

//登录页面提示
function callBackCodeLogin(result){
    let style = document.getElementById('alert');
    switch (result.code){
        case 0 :
            style.style.display='block';
            style.value='账号或密码不能为空';
            break;
        case 1 :
            style.style.display='block';
            style.value='您还没有注册';
            break;
        case 2 :
            style.style.display='block';
            style.value='账号或密码有误';
            break;
        case 3 :
            function jump(){window.location = result.data["web"] + result.data["user"]}

            style.style.color='#00FF44FF';
            style.style.backgroundColor='rgba(0, 255, 68, 0.4)';
            style.style.borderColor='#18c300';
            style.style.display='block';
            style.value='登录成功';

            setTimeout(jump,800);
            break;
        default :
            alert('Unknown Error')
    }
}

//注册页面提示
function callBackCodeReg(result){
    let style = document.getElementById('alert');
    switch (result.code){
        case 0 :
            style.style.display='block';
            style.value='账号或密码不能为空';
            break;
        case 1 :
            style.style.display='block';
            style.value='邀请码错误';
            break;
        case 2 :
            style.style.display='block';
            style.value='账号已经存在';
            break;
        case 3 :
            alert('服务器错误')
            break;
        case 4 :
            function jump(){window.location = './login.html'}

            style.style.color='#00FF44FF';
            style.style.backgroundColor='rgba(0, 255, 68, 0.4)';
            style.style.borderColor='#18c300';
            style.style.display='block';
            style.value='注册成功';

            setTimeout(jump,800);
            break;
        default :
            alert('Unknown Error');
    }
}

//淡入淡出
function fadeInS(element,speed){
    let ele = document.getElementById(element);
    if (ele.style.opacity !=='1'){
        ele.style.display='block';
        let num = 0;
        let st = setInterval(function (){
            num++;
            ele.style.opacity = num/10;
            if (num >= 10){
                clearInterval(st);
            }
        },speed);
    }
}

function fadeOutS(element,speed){
    let ele = document.getElementById(element);
    if (ele.style.opacity !=='0'){
        let num = 10;
        let st = setInterval(function (){
            num--;
            ele.style.opacity = '0.'+num;
            if (num <= 0){
                clearInterval(st);
                ele.style.display = 'none'
            }
        },speed);
    }
}