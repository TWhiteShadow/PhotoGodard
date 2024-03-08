
// init magnific popup
document.querySelector('.img-gallery-magnific') && ( () => {
    $(window).load(function () {
        document.querySelector("html").classList.remove("md:overflow-hidden");
        document.querySelector("html").classList.remove("overflow-scroll");

        $('.img-gallery-magnific').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            fixedContentPos: false,
            gallery: {
                enabled: true,
                preload: [0, 2]
            },
            autoFocusLast:false,
            zoom: {
                enabled: true,

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
            },
            retina: {
                ratio: 1,
                // Increase this number to enable retina image support.
                // Image in popup will be scaled down by this number.
                // Option can also be a function which should return a number (in case you support multiple ratios). For example:
                // ratio: function() { return window.devicePixelRatio === 1.5 ? 1.5 : 2  }


                replaceSrc: function (item, ratio) {
                    return item.src.replace(/\.\w+$/, function (m) {
                        return '@2x' + m;
                    });
                } // function that changes image source
            },
            callbacks: {
                beforeOpen: function() {
                    $('body').css("overflow", "hidden");
                },
                beforeClose: function() {
                    $('body').css("overflow", "auto");
                },
                open: function () {
                    let startX;
                    const swipeArea = document.querySelector('.mfp-container');
                    swipeArea.addEventListener('touchstart', handleTouchStart, false);
                    swipeArea.addEventListener('touchmove', handleTouchMove, false);

                    function handleTouchStart(event) {
                        startX = event.touches[0].clientX;
                    }
                    function handleTouchMove(event) {
                        if (!startX)
                            return;
                        const currentX = event.touches[0].clientX;
                        const deltaX = currentX - startX;

                        if (Math.abs(deltaX) > 50) { // Adjust the threshold as needed
                            if (deltaX > 0) { // Swipe right
                                document.querySelector('.mfp-arrow-left').click();
                            } else { // Swipe left
                                document.querySelector('.mfp-arrow-right').click();
                            }

                            // Reset startX to null after detecting the swipe
                            startX = null;

                            // Prevent default touchmove behavior (scrolling)
                            event.preventDefault();
                        }
                    }
                }
            }
        });
        $.extend(true, $.magnificPopup.defaults, {
            tClose: 'Fermer (Esc)', // Alt text on close button
            tLoading: 'Chargement...', // Text that is displayed during loading. Can contain %curr% and %total% keys
            gallery: {
                tPrev: 'Précédent (flèche gauche)', // Alt text on left arrow
                tNext: 'Suivant (flèche droite)', // Alt text on right arrow
                tCounter: '%curr% sur %total%' // Markup for "1 of 7" counter
            },
            image: {
                tError: '<a href="%url%">L\'image</a> n\'a pas pu être chargée.', // Error message when image n\'a pas pu être chargée.'
            },
            ajax: {
                tError: '<a href="%url%">Le contenu</a> n\'a pas pu être chargé.', // Error message when ajax request failed
            }
        });
    });
})();

