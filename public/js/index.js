$('#fullpage').fullpage({
	responsiveWidth: 768,
	licenceKey: 'YWx2YXJvdHJpZ28uY29tX01mU2MyTnliMnhzU0c5eWFYcHZiblJoYkd4NVNRcg==',
	menu: "#sidebar",
	anchors: ['home', "about", "works", "albums", "contacts"],
	scrollingSpeed: 700,
	loopTop: false,
	loopBottom: true,
	fitToSection: true,
	fitToSectionDelay: 600,
	setResponsive:true,
});

var swiper = new Swiper(".mySwiper", {
	speed: 700,
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
	speed: 700,

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
	speed: 700,
	slidesPerGroup: 1,
	grid: {
		rows: 1,
	},
	loopAddBlankSlides: true,
	loopAdditionalSlides: 1,
	on: {
		beforeInit: function () {
			let numOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide");
			if (numOfSlides.length > 8) {
				this.params.loop = true;
			}
			if (numOfSlides.length == 1) {
				this.params.grid.rows = 1;
				numOfSlides[0].classList.add("heightImportant");
			}
			console.log(this.params.loop);
		},
		update: function () {
			let numOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide");
			console.log(numOfSlides.length);
			if (numOfSlides.length == 1) {
				this.params.grid.rows = 1;
				numOfSlides[0].classList.add("heightImportant");
			}else{
                numOfSlides.forEach((e) => e.classList.remove("heightImportant"));
				if (window.innerWidth >= 768) {
					this.params.grid.rows = 2;
				}
			}
			console.log(this.params.grid.rows);
		},
	},
	breakpoints: {
		768: {
			// centeredSlides: false,
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
	var input = document.getElementById("filterAlbumsInput");
	var wrapper;
	var filter = input.value.toUpperCase();
	wrapper = document.getElementById("albumSwipperWrapper");

	fetch("/findAlbumByName?value=" + filter.trim(), {})
		.then(response => {
			if (response.ok) {
				document.querySelector(".sliderOverlay").style.opacity = 0;
				document.querySelector(".sliderOverlay").style.zIndex = 0;
				return response.text();
			} else {
				document.querySelector(".sliderOverlay").style.opacity = 1;
				document.querySelector(".sliderOverlay").style.zIndex = 30;
				return "";
			}
			return response.text(); // Parse response as text
		})
		.then(html => {
			if (html != "") {
				wrapper.innerHTML = html; // Set the HTML content to the wrapper
				atroposInit();
				swiperAlbum.update(); // Update swiper after setting HTML
				swiperAlbum.update(); // IMPORTANT: removes height and fixes row
			}
		})
		.catch(error => {
			console.error('Error fetching albums:', error);
		});
}

// A little delay
let typingTimer;
let typeInterval = 500; // 500 milliseconds
var input = document.getElementById("filterAlbumsInput");

input.addEventListener('input', () => {
	clearTimeout(typingTimer);
	typingTimer = setTimeout(filterAlbums, typeInterval); // Pass the function reference, not invocation
});