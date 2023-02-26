/**
 * JS对QQ账号合法性的检测
 *
 * @returns {boolean}
 */

//QQ号检查
function checkAccount() {
    let accountValue  = document.getElementById("account").value;
    let pattern = /^[1-9][0-9]{4,12}$/;

    if (pattern.test(accountValue)){
        return true
    }
    else {
        document.getElementById('alert').style.display='block';
        document.getElementById('alert').value='账号格式错误';
        return false;
    }
}

//检查输入是否为空
function checkNull() {
    let accountValue = document.getElementById('account').value;
    let passwordValue = document.getElementById('password').value;

    if (accountValue === '' || passwordValue === ''){
        document.getElementById('alert').style.display='block';
        document.getElementById('alert').value='账号或密码不能为空';
        return false
    }
    return true
}

/**
 * 注册时对密码强度及再次输入是否相同
 * @returns {boolean}
 */
//密码初次校验
function checkRegPassword() {
    let rePasswordArea = document.getElementById("rePassword");

    let passwordValue = document.getElementById("password").value;
    let rePasswordValue = document.getElementById("rePassword").value;

    if (passwordValue.length<6||passwordValue.length>20) {
        document.getElementById('alert').style.display='block';
        document.getElementById('alert').value='密码长度应为6-20位';
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

/**
 * 用于在界面显示当前用户名称
 *
 * @param par
 * @returns {number|string}
 */
//GET User
function getPar(par){

    const local_url = document.location.href;
    const get = local_url.indexOf(par + "=");
    if(get === -1){
        return 0;
    }
    let get_par = local_url.slice(par.length + get + 1);

    const nextPar = get_par.indexOf("&");
    if(nextPar !== -1){
        get_par = get_par.slice(0, nextPar);
    }
    return get_par;
}

/**
 * 实现淡入淡出
 * @param element
 * @param speed
 */
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
