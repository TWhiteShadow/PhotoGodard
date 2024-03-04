const footerYear = document.getElementById('year');
footerYear && (() => {
    footerYear.innerText = new Date().getFullYear();
})();
document.getElementById("footer") && document.addEventListener("scroll", function () {
    var scrollY = window.scrollY;
    if (scrollY > 20) {
        document.getElementById("footer").classList.remove("hide");
    } else {
        document.getElementById("footer").classList.add("hide");
    }
});