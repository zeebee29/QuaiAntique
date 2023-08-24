document.addEventListener("DOMContentLoaded", function() {
    var path = window.location.pathname;
    var referrerPath = new URL(document.referrer).pathname;
    var currentURL = window.location.href;
    var links = document.getElementsByClassName("nav-link");
    for (var i = 0; i < links.length; i++) {
        var href = links[i].getAttribute("href");
        console.log("p",path);
        console.log("r",referrerPath);
        console.log("==> h",href);
        console.log("c",currentURL);
    if (path === href) {
        links[i].classList.add("active");
    } 
    }
});

let prevScrollPos = window.pageYOffset;

window.onscroll = function() {
    let currentScrollPos = window.pageYOffset;
    
    if (prevScrollPos > currentScrollPos) {
        document.querySelector(".navbar").style.top = "0";
    } else {
        document.querySelector(".navbar").style.top = "-100px";
    }
    
    prevScrollPos = currentScrollPos;
}