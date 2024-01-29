$(document).ready(function () {
	$('#fullpage').fullpage({
		responsiveWidth: 768,
		licenceKey: 'YWx2YXJvdHJpZ28uY29tX01mU2MyTnliMnhzU0c5eWFYcHZiblJoYkd4NVNRcg==',
		menu: "#sidebar",
		anchors: ['home', "about", "works", "albums", "contacts"],
		scrollingSpeed: 1000,
		dragAndMove: true,
		loopTop: false,
		loopBottom: true,
		fitToSection: true,
		fitToSectionDelay: 600,
	});

	var swiper = new Swiper(".mySwiper", {
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
		edgeSwipeDetection: true,
		loop: true,
	});
});
