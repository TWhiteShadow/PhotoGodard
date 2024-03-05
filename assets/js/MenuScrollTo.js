function debounce(func, timeout = 250){
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}


class MenuScrollTo  {

    constructor() {
        if (window.localStorage.getItem('previousHash') !== undefined && window.localStorage.getItem('previousHash') !== null) {
            document.querySelector('#fullpage').classList.remove('scroll-smooth');
            window.location.hash = window.localStorage.getItem('previousHash');
            document.querySelector('#fullpage').classList.add('scroll-smooth');
            window.localStorage.removeItem("previousHash");
        
        }
        this.previousWidth = 999999999;
        this.homeDivDisplay = document.querySelector(".homeSectionMobile").currentStyle ? document.querySelector(".homeSectionMobile").currentStyle.display : getComputedStyle(document.querySelector(".homeSectionMobile"), null).display;
    }

    

    smoothScrollTo(target, duration) {
        const targetElement = document.querySelector(target);
        if (!targetElement) return;
    
        let start = window.scrollY;
        let startTime = performance.now();
    
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
   
    handleResize(){
        const self = this;
    
        const debounceScroll = debounce((e) => {
            e.preventDefault();
            const targetElementId = e.target.getAttribute("href");
            $("html, body").addClass("scroll-smooth")
            self.smoothScrollTo(targetElementId, 1000);
        }, 800);
    
        window.addEventListener("resize", (event) => {
            const width = window.innerWidth;
            if (width < self.previousWidth && width < 768) {
                self.previousWidth = width;
            }
            if (width > self.previousWidth && width >= 768) {
                const hash = window.location.hash
                if (hash != '#home') {
                    // const defaultUrl = window.location.toString();
                    // const url = defaultUrl.split("/#")[0];
                    // window.localStorage.setItem('previousHash', hash);
                    // window.location = url;
                }
                self.previousWidth = width;
            }
            if (width <= 768) {
                if (self.homeDivDisplay == "block") {
                    document.getElementsByClassName("homeSectionMobile")[0].id = "home";
                    document
                        .querySelector("#menuBurgerHomeHref")
                        .addEventListener("click", debounceScroll);
                };
            } else {
                document.getElementsByClassName("homeSectionMobile")[0].id = "";
            }
        });
    
    }
    

    handleDOMContentLoaded(){
        const self = this;
        // FIX a href error on mobile devices (<= 768)
        document.addEventListener("DOMContentLoaded", (e) => {
            const width = window.innerWidth;
            if (width <= 768) {
                if (this.homeDivDisplay == "block") {
                    document.getElementsByClassName("homeSectionMobile")[0].id = "home";
                    document
                        .querySelector("#menuBurgerHomeHref")
                        .addEventListener("click", function (e) {
                            e.preventDefault();
                            const targetElementId = this.getAttribute("href");
                            $("html, body").addClass("scroll-smooth");
                            self.smoothScrollTo(targetElementId, 1000);
                        });
                };
            } else {
                document.getElementsByClassName("homeSectionMobile")[0].id = "";
            }
        });

    }

    init() {
        this.handleResize();
        this.handleDOMContentLoaded();
    }

}
document.querySelector(".homeSectionMobile") ? new MenuScrollTo().init() : null;
