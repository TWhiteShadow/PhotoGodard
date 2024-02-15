/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// // code for parallax left top right
var scene = document.getElementById("scene");
var parallaxInstance = new Parallax(scene);

// // code for parallax left top right
var sceneContact = document.getElementById("sceneContact");
var parallaxInstanceContact = new Parallax(sceneContact);

// import Atropos library
import Atropos from "atropos";


var touchScreen = false;
if ('ontouchstart' in window) {
    var touchScreen = true;
}
var homeDivDisplay = document.querySelector(".homeSectionMobile").currentStyle ? document.querySelector(".homeSectionMobile").currentStyle.display : getComputedStyle(document.querySelector(".homeSectionMobile"), null).display;

// // code for scroll to top on devices who have a width <= 768px 
function smoothScrollTo(target, duration) {
    const targetElement = document.querySelector(target);
    if (!targetElement) return;

    const start = window.scrollY;
    const startTime = performance.now();

    function scrollAnimation(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);

        window.scrollTo(
            0,
            start + (targetElement.getBoundingClientRect().top - start) * progress
        );

        if (progress < 1) {
            requestAnimationFrame(scrollAnimation);
        }
    }

    requestAnimationFrame(scrollAnimation);
}
if (window.localStorage.getItem('previousHash') !== undefined && window.localStorage.getItem('previousHash') !== null) {
    document.querySelector('#fullpage').classList.remove('scroll-smooth');
    window.location.hash = window.localStorage.getItem('previousHash');
    document.querySelector('#fullpage').classList.add('scroll-smooth');
    window.localStorage.removeItem("previousHash");

}
var previousWidth = 999999999;

window.addEventListener("resize", (event) => {

    var width = window.innerWidth;
    if (width < previousWidth && width < 768) {
        previousWidth = width;
    }
    if (width > previousWidth && width >= 768) {
        var hash = window.location.hash
        if (hash != '#home') {
            var defaultUrl = window.location.toString();
            var url = defaultUrl.split("/#")[0];
            window.localStorage.setItem('previousHash', hash);
            window.location = url;
        }
        previousWidth = 999999999;
    }
    if (width <= 768) {
        if (homeDivDisplay == "block") {
            document.getElementsByClassName("homeSectionMobile")[0].id = "home";
            document
                .querySelector("#menuBurgerHomeHref")
                .addEventListener("click", function (e) {
                    e.preventDefault();
                    const targetElementId = this.getAttribute("href");
                    $("html, body").addClass("scroll-smooth")
                    smoothScrollTo(targetElementId, 1000);
                });
        };
    } else {
        document.getElementsByClassName("homeSectionMobile")[0].id = "";
    }
});
document.addEventListener("DOMContentLoaded", (e) => {
    var width = window.innerWidth;
    if (width <= 768) {
        if (homeDivDisplay == "block") {
            document.getElementsByClassName("homeSectionMobile")[0].id = "home";
            document
                .querySelector("#menuBurgerHomeHref")
                .addEventListener("click", function (e) {
                    e.preventDefault();
                    const targetElementId = this.getAttribute("href");
                    $("html, body").addClass("scroll-smooth");
                    smoothScrollTo(targetElementId, 1000);
                });
        };
    } else {
        document.getElementsByClassName("homeSectionMobile")[0].id = "";
    }
});



// Menu burger open function
$(".menu").click(function () {
    $(this).toggleClass("open");
    $(".overlay").toggleClass("showOverlay");
    spanMenuOverlayActiveChange();
});

$(document).keyup(function (e) {
    if ((e.key === "Escape" || e.key === "Enter") && $(".menu").hasClass("open")) {
        closeOverlay();
    }
});

function closeOverlay() {
    if ($(".menu").hasClass("open")) {
        $(".overlay").toggleClass("showOverlay");
        $(".menu").toggleClass("open");
    }
};

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

// SIDEBAR SCRIPT

// Using an observer to detect when the user scrolls the page and which sections is being seen
const sections = document.querySelectorAll("section");
const sidebarSpans = document.querySelectorAll("#sidebar span");

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                sidebarSpans.forEach((span) => {
                    if (
                        entry.target.id ===
                        span.parentElement.getAttribute("href").substring(1)
                    ) {
                        span.parentElement.classList.add("active");
                        history.pushState(
                            null,
                            null,
                            span.parentElement.getAttribute("href")
                        );
                    } else {
                        span.parentElement.classList.remove("active");
                    }
                });
            } else {
            }
        });
    },
    {
        threshold: 0.9,
    }
);

sections.forEach((element) => {
    observer.observe(element);
});


function spanMenuOverlayActiveChange() {
    var overlay = document.querySelector(".overlay");
    var overlayMenuSpans = overlay.querySelectorAll("span");

    overlayMenuSpans.forEach((span) => {
        span.addEventListener("click", (event) => { closeOverlay(); });
        if (span.parentElement.getAttribute("href") === window.location.hash) {
            span.classList.add("active");
        } else {
            span.classList.remove("active");
        }
    });
};

addEventListener("hashchange", (event) => {
    spanMenuOverlayActiveChange();
});


document.getElementById('year').innerText = new Date().getFullYear();

document.addEventListener("scroll", function () {
    var scrollY = window.scrollY;
    if (scrollY > 20) {
        document.querySelector("footer").classList.remove("hide");
    } else {
        document.querySelector("footer").classList.add("hide");
    }
});



// CANVAS STROKE

if (!touchScreen) {
    const canvas = document.querySelector("canvas");
    const ctx = canvas.getContext('2d');

    // for intro motion
    let mouseMoved = false;

    const pointer = {
        x: .5 * window.innerWidth,
        y: .5 * window.innerHeight,
    }
    const params = {
        pointsNumber: 10,
        widthFactor: .3,
        mouseThreshold: 1,
        spring: .4,
        friction: .5
    };

    const trail = new Array(params.pointsNumber);
    for (let i = 0; i < params.pointsNumber; i++) {
        trail[i] = {
            x: pointer.x,
            y: pointer.y,
            dx: 0,
            dy: 0,
        }
    }

    window.addEventListener("click", e => {
        updateMousePosition(e.pageX, e.pageY);
    });
    window.addEventListener("mousemove", e => {
        mouseMoved = true;
        updateMousePosition(e.pageX, e.pageY);
    });
    window.addEventListener("touchmove", e => {
        mouseMoved = true;
        updateMousePosition(e.targetTouches[0].pageX, e.targetTouches[0].pageY);
    });

    function updateMousePosition(eX, eY) {
        pointer.x = eX;
        pointer.y = eY;
    }

    setupCanvas();
    update(0);
    window.addEventListener("resize", setupCanvas);

    function update(t) {
        var allElements = document.querySelectorAll(".atropos-scale");
        allElements.forEach((element) => {
            element.addEventListener("mouseover", () => {
                ctx.strokeStyle = "#f3f4f6";
            });
            element.addEventListener("mouseout", () => {
                ctx.strokeStyle = "black"
            });
        });
        // for intro motion
        // if (!mouseMoved) {
        //     pointer.x = (.5 + .3 * Math.cos(.002 * t) * (Math.sin(.005 * t))) * window.innerWidth;
        //     pointer.y = (.5 + .2 * (Math.cos(.005 * t)) + .1 * Math.cos(.01 * t)) * window.innerHeight;
        // }

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        trail.forEach((p, pIdx) => {
            const prev = pIdx === 0 ? pointer : trail[pIdx - 1];
            const spring = pIdx === 0 ? .4 * params.spring : params.spring;
            p.dx += (prev.x - p.x) * spring;
            p.dy += (prev.y - p.y) * spring;
            p.dx *= params.friction;
            p.dy *= params.friction;
            p.x += p.dx;
            p.y += p.dy;
        });

        ctx.lineCap = "round";
        ctx.beginPath();
        ctx.moveTo(trail[0].x, trail[0].y);

        for (let i = 1; i < trail.length - 1; i++) {
            const xc = .5 * (trail[i].x + trail[i + 1].x);
            const yc = .5 * (trail[i].y + trail[i + 1].y);
            ctx.quadraticCurveTo(trail[i].x, trail[i].y, xc, yc);
            ctx.lineWidth = params.widthFactor * (params.pointsNumber - i);
            ctx.stroke();
        }
        ctx.lineTo(trail[trail.length - 1].x, trail[trail.length - 1].y);
        ctx.stroke();

        window.requestAnimationFrame(update);
    }

    function setupCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
}