export default function fullpageInit(){
  
  let isIOS = (function () {
    var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    var isAppleDevice = navigator.userAgent.includes('Macintosh');
    return isIOS || (isAppleDevice);
  })();

  let isSmallViewport = window.innerWidth > 768;
  
  
  $('#fullpage').fullpage({
    responsiveWidth: 767,
    licenceKey: 'YWx2YXJvdHJpZ28uY29tX01mU2MyTnliMnhzU0c5eWFYcHZiblJoYkd4NVNRcg==',
    menu: "#sidebar",
    anchors: ['home', "about", "works", "albums", "contacts"],
    scrollingSpeed: 1000,
    loopTop: false,
    loopBottom: true,
    fitToSection: true,
    setResponsive:true,
    touchSensitivity: 10,
    bigSectionsDestination: "top",
    animateAnchor: false,
    scrollBar:true,
    // scrollBar: isSmallViewport || isIOS,
    // afterResponsive: function(isResponsive) {
    //   if (!isResponsive && !isIOS) {
    //     this.scrollBar = false;
    //     $('#fullpage').reBuild();
    //   } else {
    //     this.scrollBar = true;
    //     $('#fullpage').reBuild();
    //   }
    // },
  });
}
document.getElementById('fullpage') && fullpageInit();

