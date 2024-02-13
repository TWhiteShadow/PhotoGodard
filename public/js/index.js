
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
	slidesPerView: 1.4,
	centeredSlides: true,
	spaceBetween: 30,
	grabCursor: true,
	keyboard: true,
	observer: true,

	// Navigation arrows
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
	breakpoints: {
		768: {
			slidesPerView: 2,
		}
	},

	on: {
		init: function () {
			console.log('swiper init');
		},
	}
});
const swiperAlbum = new Swiper('.swiper3', {
	// Optional parameters
	direction: 'horizontal',
	loop: false,
	slidesPerView: 1.35,
	centeredSlides: true,
	spaceBetween: 30,
	grabCursor: true,
	keyboard: true,
	observer: true,
	speed: 1000,
	slidesPerGroup: 1,
	grid: {
		rows: 2,
	},
	on: {
		beforeInit: function () {
			let numOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
			if (numOfSlides > 8) {
				this.params.loop = true;
			}
			console.log(this.params.loop);
		},
	},
	breakpoints: {
		768: {
			centeredSlides: false,
			slidesPerView: 2.5,
			grid: {
				rows: 2,
			},
		}
	},
	// Navigation arrows
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
});

window.addEventListener('resize', function () {
	if (window.innerWidth < 768) {
		console.log(this.window.innerWidth);
		swiperAlbum.update();
	}
});


function filterAlbums() {
	let numOfSlides = document.querySelector(".swiper3").querySelectorAll(".swiper-slide");
	let numOfSlidesVisible = [];
	var input = document.getElementById("filterAlbumsInput");
	var wrapper, div, i, txtValue;
	var filter = input.value.toUpperCase();
	let noMatch = true;
	wrapper = document.getElementById("albumSwipperWrapper");
	div = wrapper.getElementsByClassName("swiper-slide");
	
	console.log("Initial no match : " + noMatch.toString());
	for (i = 0; i < div.length; i++) {
		h4 = div[i].getElementsByTagName("h4")[0];
		if (h4) {
			txtValue = h4.textContent || h4.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				console.log("found match");
				noMatch = false;
				div[i].style.display = ""; // Show the div if it matches the filter
			} else {
				div[i].style.display = "none"; // Hide the div if it doesn't match the filter
			}
		} else {
			if (!input.value) {
				div[i].style.display = "";
			} else {
				div[i].style.display = "none";
			}
		}
	}

	console.log("noMatch before condition : " + noMatch.toString());
	if (noMatch) {
		console.log("no match");
		for (i = 0; i < div.length; i++) {
			div[i].style.display = "";
		}
		swiperAlbum.update();
	}
	numOfSlides.forEach(function (element) {
		if (element.style.display != "none") {
			numOfSlidesVisible.push(element);
		}
	});

	if ((numOfSlidesVisible.length == 1 && numOfSlidesVisible[0].style.height != "100%")) {
		swiperAlbum.params.grid.rows = 1;
		swiperAlbum.params.centeredSlides = true;
		numOfSlidesVisible[0].classList.add("heightImportant");
		console.log("ONLY 1")
	} else {
		numOfSlidesVisible.forEach(function (element) {
			element.classList.remove("heightImportant");
		});
		swiperAlbum.params.loop = true;
		if(window.innerWidth > 768) {
			swiperAlbum.params.centeredSlides = false;
			swiperAlbum.params.grid.rows = 2;
		}
	}
	swiperAlbum.update();
}