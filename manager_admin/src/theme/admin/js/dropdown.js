// Executes the function when DOM will be loaded fully
$(document).ready(function () {	
// hover property will help us set the events for mouse enter and mouse leave
$('.areaNavi li').hover(
	// When mouse enters the .navigation element
	function () {
		//Fade in the navigation submenu
		$('ul', this).fadeIn(150); 	// fadeIn will show the sub cat menu
	}, 
	// When mouse leaves the .navigation element
	function () {
		//Fade out the navigation submenu
		$('ul', this).fadeOut(150);	 // fadeOut will hide the sub cat menu		
	}
);
});



// Executes the function when DOM will be loaded fully
$(document).ready(function () {	
// hover property will help us set the events for mouse enter and mouse leave
$('.categoryBtn li').hover(
	// When mouse enters the .navigation element
	function () {
		//Fade in the navigation submenu
		$('ul', this).fadeIn(150); 	// fadeIn will show the sub cat menu
	}, 
	// When mouse leaves the .navigation element
	function () {
		//Fade out the navigation submenu
		$('ul', this).fadeOut(150);	 // fadeOut will hide the sub cat menu		
	}
);
});