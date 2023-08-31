document.addEventListener("DOMContentLoaded", function() {
    var path = window.location.pathname;
    var referrerPath = new URL(document.referrer).pathname;
    var currentURL = window.location.href;
    var links = document.getElementsByClassName("nav-link");
    for (var i = 0; i < links.length; i++) {
        var href = links[i].getAttribute("href");
    if (path === href) {
        links[i].classList.add("active");
    } 
    }
});

let prevScrollPos = window.scrollY;

window.onscroll = function() {
    let currentScrollPos = window.scrollY;
    
    if (prevScrollPos > currentScrollPos) {
        document.querySelector(".navbar").style.top = "0";
    } else {
        document.querySelector(".navbar").style.top = "-100px";
    }
    
    prevScrollPos = currentScrollPos;
}