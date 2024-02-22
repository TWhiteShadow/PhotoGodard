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