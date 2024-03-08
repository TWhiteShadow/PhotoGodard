
import Parallax from "parallax-js";

class ParallaxInit{
    constructor() {
        this.init();
    }
    parallaxSceneHome(){
        const scene = document.getElementById("scene");
        const parallaxInstance = new Parallax(scene);
    }

    parallaxSceneContact(){
        // code for parallax left top right
        const sceneContact = document.getElementById("sceneContact");
        const parallaxInstanceContact = new Parallax(sceneContact);
    }

    init() {
        this.parallaxSceneHome();
        this.parallaxSceneContact();
    }
}

document.querySelector("#scene") && document.querySelector("#sceneContact") && new ParallaxInit().init();

