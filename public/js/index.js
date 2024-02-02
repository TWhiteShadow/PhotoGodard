$(document).ready(function () {
	$('#fullpage').fullpage({
		responsiveWidth: 768,
		licenceKey: 'YWx2YXJvdHJpZ28uY29tX01mU2MyTnliMnhzU0c5eWFYcHZiblJoYkd4NVNRcg==',
		menu: "#sidebar",
		anchors: ['home', "about", "works", "albums", "contacts"],
		scrollingSpeed: 1000,
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

	const swiper8888 = new Swiper('.swiper2', {
		// Optional parameters
		direction: 'horizontal',
		loop: true,
		slidesPerView: window.innerWidth < 768 ? 1.4 : 2,
		centeredSlides: true,
		spaceBetween: 30,
		grabCursor: true,
		keyboard: true,
	  
		// Navigation arrows
		navigation: {
		  nextEl: '.swiper-button-next',
		  prevEl: '.swiper-button-prev',
		},
	  });
	  
});
