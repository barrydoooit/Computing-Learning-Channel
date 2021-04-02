$(document).ready(function () {
    setTimeout(function(){
        document.body.className="";
    },500);
    $(".like").click(function () {
        $(this).toggleClass("liked");
        console.log("clicked");
    })
});