class Spinner{
    imageLoadedCounter(){
        let images = document.querySelectorAll( "img" );
        let total = images.length;
        let counter = 0;
        images.forEach((image) => {
            image.addEventListener( "load", () => {
                counter++;
                document.querySelector('#spinner-text').innerHTML = `${counter} images chargées sur ${total}...`;
            });
        });
        this.defaultSpinner();
    }
    defaultSpinner(){
        window.addEventListener('load', function() {
           document.querySelector('.spinner').classList.toggle('hideSpinner');
           document.querySelector("html").classList.remove("overflow-hidden");
           setTimeout(function() {
               document.querySelector('.spinner').remove();
           }, 500);
        });
    }
    init(){
        if(document.getElementById('content')){
            this.imageLoadedCounter();
        }else{
            this.defaultSpinner();
        }
    }
}
new Spinner().init();