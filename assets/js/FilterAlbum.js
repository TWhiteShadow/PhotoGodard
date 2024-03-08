import atroposInit from "./Atropos.js";
import fullpageInit from "./Fullpage.js";

function filterAlbums() {
    var input = document.getElementById("filterAlbumsInput");
    var wrapper;
    var filter = input.value.toUpperCase();
    wrapper = document.getElementById("albumSwipperWrapper");

    fetch("/findAlbumByName?value=" + filter.trim(), {})
        .then(response => {
            if (response.ok) {
                document.querySelector(".sliderOverlay").style.opacity = 0;
                document.querySelector(".sliderOverlay").style.zIndex = 0;
                return response.text();
            } else {
                document.querySelector(".sliderOverlay").style.opacity = 1;
                document.querySelector(".sliderOverlay").style.zIndex = 30;
                return "";
            }
            return response.text(); // Parse response as text
        })
        .then(html => {
            if (html != "") {
                wrapper.innerHTML = html; // Set the HTML content to the wrapper
                // FOR LAZY LOADING WITH DATA-SRC
                // wrapper.querySelectorAll('img').forEach(element => {
                //     element.src = element.src;
                // });
                atroposInit();
                swiperAlbum.update(); // Update swiper after setting HTML
                swiperAlbum.update(); // IMPORTANT: removes height and fixes row
            }
        })
        .catch(error => {
            console.error('Error fetching albums:', error);
        });
    }

// A little delay
let typingTimer;
let typeInterval = 500; // 500 milliseconds
var input = document.getElementById("filterAlbumsInput");
(input) && ( () => {
    input.addEventListener('input', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(filterAlbums, typeInterval); // Pass the function reference, not invocation
    });

})();
