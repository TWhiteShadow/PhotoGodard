/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// code for parallax left top right
var scene = document.getElementById('scene');
var parallaxInstance = new Parallax(scene);



const cards = document.querySelectorAll(".card");
let bounds;
let img;
function rotateToMouse(e, card, img) {
    const mouseX = e.clientX;
    const mouseY = e.clientY;
    const leftX = mouseX - bounds.x;
    const topY = mouseY - bounds.y;
    const center = {
        x: leftX - bounds.width / 2,
        y: topY - bounds.height / 2,
    };
    const distance = Math.sqrt(center.x ** 2 + center.y ** 2);

    card.style.transform = `
    rotate3d(
      ${center.y / 100},
      ${-center.x / 100},
      0,
      ${Math.log(distance) * 3}deg
    )
  `;
    const depthX = `${(mouseX - bounds.width / 2) * 0.2}%`;
    const depthY = `${(mouseY - bounds.height / 2) * 0.1}%`;
    // console.log(`${depthX} ${depthY}`);
    card.style.backgroundPosition = `${depthX} ${depthY}`;
}

cards.forEach((card) => {
    card.addEventListener("mouseenter", (event) => {
        bounds = card.getBoundingClientRect();
        img = card.querySelector("img");
        card.addEventListener("mousemove", (event) => {
            rotateToMouse(event, card, img);
        });
    });

    card.addEventListener("mouseleave", () => {
        card.removeEventListener("mousemove", rotateToMouse);
        card.style.transition = "transform 1s cubic-bezier(0.23, 1, 0.32, 1)"; // Ajoute la transition CSS

        // Revert à la position de base après la transition
        card.style.transform = "scale3d(1, 1, 1) rotate3d(0, 0, 0, 0deg)";

        // Supprime la transition après qu'elle soit terminée
        setTimeout(() => {
            card.style.transition = "";
        }, 500);
    });
});




// SIDEBAR SCRIPT

// Using an observer to detect when the user scrolls the page and which sections is being seen
const sections = document.querySelectorAll("section");
const sidebarSpans = document.querySelectorAll("#sidebar span");

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            sidebarSpans.forEach(span => {
                if (entry.target.id === span.parentElement.getAttribute('href').substring(1)) {
                    span.parentElement.classList.add("active")
                    history.pushState(null,null,span.parentElement.getAttribute('href'));
                }else{
                    span.parentElement.classList.remove("active")
                }
            });
        } else {
        }
    });
},
{
    threshold: 0.9
});

sections.forEach(element => {
    observer.observe(element);
});