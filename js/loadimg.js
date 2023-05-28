// JavaScript Document
var images = new Array(
	'../img/buttonbg_hover.png', '../img/navigation_hover.png', '../img/slide_left_hover.png', '../img/slide_right_hover.png', '../img/download_hover.png');
	
	for (i = 0; i < images.length(); i++) {
		var img = new Image();
		img.src = images[i];
	}