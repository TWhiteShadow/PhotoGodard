import Atropos from "atropos";

let touchScreen = false;
if ('ontouchstart' in window) {
    touchScreen = true;
}

export default function atroposInit() {
    if (touchScreen) {
        // Initialize
        const allAtroposScales = document.querySelectorAll(".atropos-scale");
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
