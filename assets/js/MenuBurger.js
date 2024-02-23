class MenuBurger  {

    constructor() {
        const overlayMenuSpans = document.querySelector(".overlay").querySelectorAll("span");
        overlayMenuSpans.forEach((span) => {
            span.addEventListener("click", (event) => { this.closeOverlay(); })
        });
    }

    closeOverlay() {
        if( document.querySelector(".menu").classList.contains("open") ){
            document.querySelector(".overlay").classList.toggle("showOverlay");
            document.querySelector(".menu").classList.toggle("open");
        }
    };

    spanMenuOverlayActiveChange(){
        const overlay = document.querySelector(".overlay");
        const overlayMenuSpans = overlay.querySelectorAll("span");
    
        overlayMenuSpans.forEach((span) => {
            if (span.parentElement.getAttribute("href") === window.location.hash) {
                span.classList.add("active");
            } else {
                span.classList.remove("active");
            }
        });
    };
    
    openMenuEvent(){
        document.querySelector(".menu").addEventListener("click", (e) => {
            e.currentTarget.classList.toggle("open");
            
            let overlayElement = document.querySelector(".overlay");
            
            overlayElement.classList.toggle("showOverlay");
            
            this.spanMenuOverlayActiveChange();
        });

    }

    handleKeyUpToClose(){ 
        document.addEventListener("keyup", (e) => {
            if ((e.key === "Escape" || e.key === "Enter") && document.querySelector(".menu").classList.contains("open")) {
                this.closeOverlay();
            }
        });

    }
   
    handleHashChange(){
        addEventListener("hashchange", (event) => {
            this.spanMenuOverlayActiveChange();
        });
    }

    init(){
        this.openMenuEvent();
        this.handleKeyUpToClose();
        this.handleHashChange();
    }
}
document.querySelector(".menu") && new MenuBurger().init();
