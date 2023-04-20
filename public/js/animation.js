
function ripple(ele) {
    ele.addEventListener("click", (e) => {
        let x = e.clientX - e.target.offsetLeft;
        let y = e.clientY - e.target.offsetTop - 100;

        let ripples = document.createElement("span");
        ripples.style.left = x + 'px';
        ripples.style.top = y + 'px';

        ele.appendChild(ripples);

        setTimeout(() => {
            ripples.remove();
        },800)
    })
}

const eleRipple = document.getElementsByClassName('ripple');

for (i= 0; i<eleRipple.length; i++){
    ripple(eleRipple[i])
}
