const buttons = [
    document.getElementById("oer-btn"),
    document.getElementById("sdt-btn"),
    document.getElementById("ssr-btn")
];

const contents = [
    document.getElementById("oer-content"),
    document.getElementById("sdt-content"),
    document.getElementById("ssr-content")
]
curContentIndex = 0;
$(document).ready(function () {
    buttons[0].classList.add('active');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttonIndex = buttons.indexOf(button);
            if (buttonIndex != curContentIndex) {
                content = contents[buttonIndex];
                content.style.display = "block";
                contents[curContentIndex].style.display = "none";
                buttons[curContentIndex].classList.remove('active');
                button.classList.add('active');
                curContentIndex = buttonIndex;
            }
        });
    });
})