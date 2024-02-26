var prevScrollpos = window.scrollY;
let isScrollingToTop = false;
window.onscroll = function() {
    var currentScrollPos = window.scrollY;
    if (prevScrollpos > currentScrollPos) {
        isScrollingToTop = true;
        document.getElementById("navbar").style.setProperty('top', '0px', 'important');
    } else {
        document.getElementById("navbar").style.setProperty('top', '-100px', 'important');
        Array.from(document.querySelector(".imagePreview").children).forEach((child) => {
            child.classList.add("transition-all", "duration-300", "opacity-0");
        });
    }
    prevScrollpos = currentScrollPos;
} 
// Options pour l'observer
const options = {
    threshold: 0.2 // seuil de visibilité
};

// Fonction de callback pour l'observer
const callback = (entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && isScrollingToTop) {
            // Si l'élément est visible, ajoutez l'opacité aux enfants de .imagePreview
            Array.from(document.querySelector(".imagePreview").children).forEach((child) => {
                child.classList.add("opacity-1");
                child.classList.remove("opacity-0");
            });
        } 
    });
};

// Créer un nouvel observer avec la fonction de callback et les options
const observer = new IntersectionObserver(callback, options);

// Observer l'élément .imagePreview
observer.observe(document.querySelector('.imagePreview'));


document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    console.log(anchor)
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
