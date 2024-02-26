var prevScrollpos = window.scrollY;
window.onscroll = function() {
    var currentScrollPos = window.scrollY;
    if (prevScrollpos > currentScrollPos) {
      document.getElementById("navbar").style.setProperty('top', '0px', 'important');
    } else {
      document.getElementById("navbar").style.setProperty('top', '-100px', 'important');
    }
    prevScrollpos = currentScrollPos;
} 

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    console.log(anchor)
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
