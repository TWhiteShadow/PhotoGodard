export default class MenuBurger  {

    closeOverlay() {
        if( document.querySelector(".menu").classList.contains("open") ){
            document.querySelector(".overlay").classList.toggle("showOverlay");
            document.querySelector(".menu").classList.toggle("open");
        }
    };

    spanMenuOverlayActiveChange() {
        const self = this;
        var overlay = document.querySelector(".overlay");
        var overlayMenuSpans = overlay.querySelectorAll("span");
    
        overlayMenuSpans.forEach((span) => {
            span.addEventListener("click", (event) => { self.closeOverlay(); });
            if (span.parentElement.getAttribute("href") === window.location.hash) {
                span.classList.add("active");
            } else {
                span.classList.remove("active");
            }
        });
    };
    
    openMenuEvent(){
        const self = this;
        document.querySelector(".menu").addEventListener("click", function(e) {
            this.classList.toggle("open");
            
            var overlayElement = document.querySelector(".overlay");
            
            overlayElement.classList.toggle("showOverlay");
            
            self.spanMenuOverlayActiveChange();
        });

    }

    handleKeyUpToClose(){ 
        const self = this;
        document.addEventListener("keyup", function(e) {
            if ((e.key === "Escape" || e.key === "Enter") && document.querySelector(".menu").classList.contains("open")) {
                self.closeOverlay();
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