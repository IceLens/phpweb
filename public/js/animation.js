
function ripple(ele,deviationY=100,deviationX=0) {
    ele.addEventListener("click", (e) => {
        let x = e.clientX - e.target.offsetLeft - deviationX;
        let y = e.clientY - e.target.offsetTop - deviationY;

        let ripples = document.createElement("span");
        ripples.style.left = x + 'px';
        ripples.style.top = y + 'px';

        ele.appendChild(ripples);

        setTimeout(() => {
            ripples.remove();
        },800)
    })
}

function move(e) {
    let cards = document.querySelectorAll(".card-content");

    cards.forEach((card) => {
        let x = e.clientX - card.getBoundingClientRect().left;
        let y = e.clientY - card.getBoundingClientRect().top;

        card.style.setProperty("--mouse-x", `${x}px`);
        card.style.setProperty("--mouse-y", `${y}px`);
    });
}

function rotate(ele,deviationX=0,deviationY=0) {
    ele.addEventListener("mousemove" ,(e) => {
        let x = (window.innerWidth / 2 - e.pageX) / 60 - deviationX;
        let y = (window.innerHeight / 2 - e.pageY) / 60 - deviationY;

        ele.style.transform = `rotateX(${-y}Deg) rotateY(${-x}Deg)`;
    })
}