import './imagesloaded.pkgd.min';
export class InfiniteScrollPhoto {
    constructor() {
        this.page = 2;
        this.shouldStop = false;
        this.maxPages = 10000;
        this.lastPageCalled = 1;
        this.isAdmin = 0;

        this.currentUrl = window.location.pathname;
        if(this.currentUrl.includes('/admin')){
            this.isAdmin = 1;
            this.currentUrl = this.currentUrl.replace('/admin','')
        }if(this.currentUrl.includes('/edit')){
            this.currentUrl = this.currentUrl.replace('/edit','')
        }
        this.init()
    }

    init() {
        // Fonction pour charger plus de données lorsque l'observateur d'intersection détecte la fin de la page
        const loadMoreData = (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.shouldStop && this.page <= this.maxPages && this.page !== this.lastPageCalled) {
                    this.insertData();
                }
            });
        };
        // Observer d'intersection pour détecter le bas de la page
        const observer = new IntersectionObserver(loadMoreData, {
            root: null,
            rootMargin: '0px',
            threshold: 0 // Déclenche lorsque 10% de l'élément cible est visible
        });

        if (document.querySelector('#footer')) {
            // Connecter l'observateur d'intersection à un élément cible (par exemple, le pied de page)
            const footer = document.querySelector('#footer'); // Remplacez #footer par l'ID de votre pied de page
            observer.observe(footer);
        };
        $('.img-gallery-magnific') && this.magnificPopup();
    }
    // Fonction pour insérer des données supplémentaires
    insertData() {
        // Si shouldStop est true, ne pas continuer
        if (this.shouldStop) {
            return;
        }
        // Charger plus de photos via AJAX
        const url = "/" + this.isAdmin + this.currentUrl + "/pagination/" + this.page;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    this.shouldStop = true;
                    return;
                }
                return response.text();
            })
            .then(html => {
                if (!this.shouldStop) {
                    html = $(html); // Convertir en objet jQuery pour Isotope
                    $('.isotopeGrid').append(html).isotope('appended', html);
                    $('.isotopeGrid').imagesLoaded().progress(function () {
                        $('.isotopeGrid').isotope('layout');
                    });
                    
                    $(document).trigger('initFavoritePicture');
                    
                    this.lastPageCalled = this.page; // Mettre à jour la dernière page appelée
                    this.page++; // Incrémenter la page pour la prochaine requête
                }else{
                    document.getElementById('loadMorePictures') && (document.getElementById('loadMorePictures').classList.add('hideAway'));
                }
            })
            .catch(error => {
                console.error('Error loading more photos:', error);
                this.shouldStop = true;
                this.maxPages = 0;
                // Arrêter l'observateur d'intersection en cas d'erreur
                observer.unobserve(footer);
            });
    };

    magnificPopup(){
        let previousElementOffsetTop = 0;
    $('.img-gallery-magnific').on('mfpOpen', function () {
        document.getElementById('footer').style.display = 'none';
        setTimeout(function () {
            document.documentElement.requestFullscreen({ navigationUI: 'hide' });
        }, 100);
        document.getElementById('navbar').style.display = 'none';
    });

    $('.img-gallery-magnific').on('mfpClose', function () {
        document.getElementById('footer').style.display = 'block';
        document.getElementById('navbar').style.setProperty('top', '-100px', '!important');
    });

    $('.img-gallery-magnific').on('mfpAfterClose', function () {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        }
        document.getElementById('navbar').style.display = 'block';
        document.getElementById('navbar').style.setProperty('top', '-100px', '!important');
    });

    addEventListener("fullscreenchange", (event) => {
        if (!document.fullscreenElement && document.getElementById('footer').style.display == 'none') {
            $.magnificPopup.instance.close()
        }
    });

    $('.img-gallery-magnific').on('mfpChange', () => {
        if ($.magnificPopup.instance.items.slice(-5)[0].src == $.magnificPopup.instance.currItem.src) {
            this.insertData();
        }
        var div = document.querySelector('.img-gallery-magnific');
        $.magnificPopup.instance.items = [];
        div.querySelectorAll('.magnific-img').forEach((e) => {
            $.magnificPopup.instance.items.push(e)
        })
        $.magnificPopup.instance.updateItemsHTML

        const clientHeightThreshold = window.innerHeight / 10;

        const offsetTopOfImagePreview = $.magnificPopup.instance.currItem.el[0].offsetParent.offsetParent.offsetTop;
        const offsetTopOfCurrentElement = offsetTopOfImagePreview + $.magnificPopup.instance.currItem.el[0].offsetTop + ($.magnificPopup.instance.currItem.el[0].getBoundingClientRect().height / 2) - (window.innerHeight / 2);
        if (previousElementOffsetTop === 0 || ((offsetTopOfCurrentElement - previousElementOffsetTop) > clientHeightThreshold || (offsetTopOfCurrentElement - previousElementOffsetTop) < -clientHeightThreshold)) {
            window.scrollTo({
                // behavior: 'smooth',
                top: offsetTopOfCurrentElement,
            });

            addEventListener("scroll", () => {
                $.magnificPopup.instance.wrap[0].style.top = window.scrollY + 'px';
                $.magnificPopup.instance.bgOverlay[0].style.height = document.querySelector('body').offsetHeight * 2 + 'px';
            });
            previousElementOffsetTop = offsetTopOfCurrentElement;
        }
    });
    }
}

document.getElementById('content') && document.addEventListener("DOMContentLoaded", function () {
    const infiniteScrollPhoto = new InfiniteScrollPhoto();

    document.getElementById('loadMorePictures') && document.getElementById('loadMorePictures').addEventListener("click", function () {
        infiniteScrollPhoto.insertData();
    });
});
