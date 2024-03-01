export let isIOS = (function () {
	var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
	var isAppleDevice = navigator.userAgent.includes('Macintosh');
	return isIOS || (isAppleDevice);
})();
document.getElementById('fullpage') && 
	$('#fullpage').fullpage({
	responsiveWidth: 768,
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
	scrollBar: isIOS,
});
