document.querySelector(".tableFooterLinks") && (() => {
    window.addEventListener("load", () => {
        document.querySelectorAll('.icon').forEach((e) =>{
            const prev = e.textContent;
            e.innerHTML = prev;
        });
    });
})();