// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// // code for parallax left top right
var scene = document.getElementById("scene");
var parallaxInstance = new Parallax(scene);

// // code for parallax left top right
var sceneContact = document.getElementById("sceneContact");
var parallaxInstanceContact = new Parallax(sceneContact);


// Gestion MenuScrollResponsive
import MenuScrollTo from "./js/MenuScrollTo";
// Gestion MenuOverlay
import MenuBurger from "./js/MenuBurger";
// SIDEBAR SCRIPT
import SidebarObserver from "./js/SidebarObserver";


// import Atropos library
import Atropos from "atropos";


var touchScreen = false;
if ('ontouchstart' in window) {
    var touchScreen = true;
}

window.atroposInit = function atroposInit() {
    if (touchScreen) {
        // Initialize
        var allAtroposScales = document.querySelectorAll(".atropos-scale");
        allAtroposScales.forEach((element) => {
            element.classList.add("activeHover");
        });
    } else {
        // Initialize
        document.querySelectorAll(".atropos-works").forEach((element) => {
            Atropos({
                el: element,
                activeOffset: 40,
                duration: 800,
                // shadow
                shadow: true,
                shadowScale: 1,
                shadowOffset: 80,
                // rest of parameters
            });
        });
    }
}
atroposInit();

document.querySelectorAll(".atropos-section-1").forEach((element) => {
    Atropos({
        el: element,
        duration: 500,
        shadow: false,
        rotateXInvert: false,
        rotateYInvert: false,
        activeOffset: 40,
        rotateXMax: 10,
        rotateYMax: 10,
        // rest of parameters
    });
});

// FOOTER DATE
document.getElementById('year').innerText = new Date().getFullYear();
