
// init Isotope
document.querySelector('.isotopeGrid') && ( () => {
    $(window).load(function () {
        $('.isotopeGrid').isotope({
            itemSelector: '.grid-item',
            masonry: {
                columnWidth: 0,
            }
        })
    });
})();

