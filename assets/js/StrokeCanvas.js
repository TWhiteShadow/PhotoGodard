class CanvasStroke {
    constructor() {
        this.touchScreen = false;
        this.destroyed = false;
        if ('ontouchstart' in window) {
            this.touchScreen = true;
        }
        if (!this.touchScreen) {
            this.canvas = document.querySelector("canvas");
            this.ctx = this.canvas.getContext('2d');
            this.mouseMoved = false;
            this.pointer = {
                x: .5 * window.innerWidth,
                y: .5 * window.innerHeight,
            };
            this.params = {
                pointsNumber: 10,
                widthFactor: .3,
                mouseThreshold: 1,
                spring: .4,
                friction: .5
            };
            this.trail = new Array(this.params.pointsNumber);
            for (let i = 0; i < this.params.pointsNumber; i++) {
                this.trail[i] = {
                    x: this.pointer.x,
                    y: this.pointer.y,
                    dx: 0,
                    dy: 0,
                };
            }
            window.addEventListener("click", e => {
                this.updateMousePosition(e.pageX, e.pageY);
            });
            window.addEventListener("mousemove", e => {
                this.mouseMoved = true;
                this.updateMousePosition(e.pageX, e.pageY);
            });
            window.addEventListener("touchmove", e => {
                this.mouseMoved = true;
                this.updateMousePosition(e.targetTouches[0].pageX, e.targetTouches[0].pageY);
            });
            this.setupCanvas();
            this.update(0);
            window.addEventListener("resize", () => {
                this.setupCanvas();
            });
            this.idleTimer = null;
            this.idleTimeout = 5000; // 5 seconds
            this.startIdleTimer();
        }
    }

    startIdleTimer() {
        this.idleTimer = setTimeout(() => {
            this.destroyContext();
        }, this.idleTimeout);
    }

    resetIdleTimer() {
        clearTimeout(this.idleTimer);
        this.startIdleTimer();
        this.destroyed = false;
    }

    destroyContext() {
        this.destroyed = true;
    }

    updateMousePosition(eX, eY) {
        this.pointer.x = eX;
        this.pointer.y = eY;
        this.resetIdleTimer();
    }
    
    update(t) {
        if(!this.destroyed){
            const allElements = document.querySelectorAll(".atropos-scale");
            allElements.forEach((element) => {
                element.addEventListener("mouseover", () => {
                    this.ctx.strokeStyle = "#f3f4f6";
                });
                element.addEventListener("mouseout", () => {
                    this.ctx.strokeStyle = "black";
                });
            });
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            this.trail.forEach((p, pIdx) => {
                const prev = pIdx === 0 ? this.pointer : this.trail[pIdx - 1];
                const spring = pIdx === 0 ? .4 * this.params.spring : this.params.spring;
                p.dx += (prev.x - p.x) * spring;
                p.dy += (prev.y - p.y) * spring;
                p.dx *= this.params.friction;
                p.dy *= this.params.friction;
                p.x += p.dx;
                p.y += p.dy;
            });
            this.ctx.lineCap = "round";
            this.ctx.beginPath();
            this.ctx.moveTo(this.trail[0].x, this.trail[0].y);
            for (let i = 1; i < this.trail.length - 1; i++) {
                const xc = .5 * (this.trail[i].x + this.trail[i + 1].x);
                const yc = .5 * (this.trail[i].y + this.trail[i + 1].y);
                this.ctx.quadraticCurveTo(this.trail[i].x, this.trail[i].y, xc, yc);
                this.ctx.lineWidth = this.params.widthFactor * (this.params.pointsNumber - i);
                this.ctx.stroke();
            }
            this.ctx.lineTo(this.trail[this.trail.length - 1].x, this.trail[this.trail.length - 1].y);
            this.ctx.stroke();
        }
        window.requestAnimationFrame((t) => {
                this.update(t);
        });
    }

    setupCanvas() {
        this.canvas.width = document.body.clientWidth;
        this.canvas.height = document.body.clientHeight;
    }
}

var isIOS = (function () {

    var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    var isAppleDevice = navigator.userAgent.includes('Macintosh');
    return isIOS || (isAppleDevice);
})();

(document.addEventListener("DOMContentLoaded", (e) =>{
    !isIOS && document.getElementById('strokeCanvas') && new CanvasStroke();
}));

