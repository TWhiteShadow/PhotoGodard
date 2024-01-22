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

// import Atropos library
import Atropos from "atropos";


// Menu burger open function
$(".menu").click(function () {
  $(this).toggleClass("open");
  $(".overlay").toggleClass("showOverlay");
  $('#fullpage').toggleClass("noScroll");
  var autoScrollingStatus = $.fn.fullpage.getFullpageData().options.autoScrolling;
  $.fn.fullpage.setAutoScrolling(!autoScrollingStatus);
});

// $(document).keyup(function(e) {
//   if (e.key === "Escape" && $(".menu").hasClass("open")) {
//   $(".overlay").toggleClass("showOverlay");
//   $('#fullpage').toggleClass("noScroll");
//   var autoScrollingStatus = $.fn.fullpage.getFullpageData().options.autoScrolling;
//   $.fn.fullpage.setAutoScrolling(!autoScrollingStatus);
// }});



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


document.getElementById('year').innerText = new Date().getFullYear();