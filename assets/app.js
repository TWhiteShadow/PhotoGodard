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

// Function to check if the element has non-zero height and width
const hasNonZeroDimensions = (element) => {
    return element.offsetHeight > 0 && element.offsetWidth > 0;
};

// Function to set up parallax effect
const setupParallax = (element) => {
    let state = {
        mouseX: 0,
        mouseY: 0,
        height: element.offsetHeight,
        width: element.offsetWidth,
    };

    console.log(state);

    element.addEventListener("mousemove", (ele) => {
        console.log("I'm hovered");
        const card = element.querySelector(".card");
        state.mouseX = ele.pageX - element.offsetLeft - state.width / 2;
        state.mouseY = ele.pageY - element.offsetTop - state.height / 2;

        // parallax angle in card
        const angleX = (state.mouseX / state.width) * 30;
        const angleY = (state.mouseY / state.height) * -30;
        card.style.transform = `rotateY(${angleX}deg) rotateX(${angleY}deg) `;
    });

    element.addEventListener("mouseout", () => {
        const card = element.querySelector(".card");
        card.style.transform = `rotateY(0deg) rotateX(0deg) `;
    });
};

// code for parallax of each image
const wrapper = document.querySelectorAll(".cardWrap");

wrapper.forEach((element) => {
    const checkAndSetup = () => {
        if (hasNonZeroDimensions(element)) {
            setupParallax(element);
            clearInterval(intervalId);
        }
    };

    const intervalId = setInterval(checkAndSetup, 100); // Adjust the interval as needed
});
