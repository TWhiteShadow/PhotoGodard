const footerYear = document.getElementById('year');
footerYear && (() => {
    footerYear.innerText = new Date().getFullYear();
})();
