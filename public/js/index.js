$(document).ready(function () {
	$('#fullpage').fullpage({
        licenceKey: 'YWx2YXJvdHJpZ28uY29tX01mU2MyTnliMnhzU0c5eWFYcHZiblJoYkd4NVNRcg==',
		menu: "#sidebar",
		anchors: ['home', "about", "works", "albums","contacts"],
		scrollingSpeed: 1000,
		dragAndMove: true,
		loopTop: false,
		loopBottom: true,
        fitToSection: true,
        fitToSectionDelay: 600,
	});
});