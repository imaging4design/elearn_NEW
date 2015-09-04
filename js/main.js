(function() {
'use strict';

/****************************************************************************************************************************/

// USED ON ALL PAGES

/****************************************************************************************************************************/

/**************************************************************/
// ANIMATE 'Total Tests Conpleted' COUNTER
/**************************************************************/

$('.count').each(function () {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 2000,
        easing: 'easeInCirc',
        step: function (now) {
            //$(this).text(Math.round(now)); // Original
            $(this).text(Intl.NumberFormat().format(Math.round(now)));
            //Intl.NumberFormat().format(1234); - Formats the ',' in thousands
        }
    });
});

/**************************************************************/




/**************************************************************/
// RESIZE 'Menu Navbar'
// Dynamically resizes the menu 'nav bar' (smaller) when scroll from top > 200px
/**************************************************************/

var element = document.querySelector('.navbar-default');
//element.classList.add('menu-bar-large');

	function menuBarResize() {
		if(window.pageYOffset > 10) {
			element.classList.add('menu-bar-small');
			element.classList.remove('menu-bar-large');
		} else {
			element.classList.add('menu-bar-large');
			element.classList.remove('menu-bar-small');
		}
	}

// Add listener event to detect scrolling
window.addEventListener('scroll', menuBarResize, false);

/**************************************************************/



/**************************************************************/
// OFF-CANVAS (Topics)
// Slides in the topics list from the right
/**************************************************************/

$(document).ready(function (){

	$('#topics-off-canvas-btn').on('click', function(){
		$('.topics-off-canvas').toggleClass( 'topics-off-canvas-show');
	});

});

/**************************************************************/
	

	/**************************************************************/
	// Make ALL images embedded in the Key Notes responsive
	/**************************************************************/

	var img = $('.key-notes img');
	img.removeAttr('width').removeAttr('height').addClass('img-responsive');
	
	/**************************************************************/


	/**************************************************************/
	// Add the special button class to the PDF download button
	/**************************************************************/

	$('.pdf').addClass('btn btn-md btn-pdf');

	/**************************************************************/


	/**************************************************************/
	// Add a dynamic 'Back to Topics' animated button
	// This shows up only when you reach the botton of the page
	/**************************************************************/

	// var scrollHeightJQuery = $(document).height();
	// var windowHeightJQuery = $(window).height();

	// var scrollHeight = document.documentElement.scrollHeight;
	// var	clientHeight = document.documentElement.clientHeight;


	// console.log('jQuery Scroll Height' + scrollHeightJQuery);
	// console.log('-------------');
	// console.log('Javascript Scroll Height' + scrollHeight);
	// console.log('-------------');
	// console.log('jQuery Client Height' + windowHeightJQuery);
	// console.log('-------------');
	// console.log('Javascript Client Height' + clientHeight);

	function backButtons() {

		var scrollHeight = $(document).height();
		var scrollTop = $(document).scrollTop();
		var	clientHeight = $(window).height();

		// Height of 'footer'
		var footerHeight = document.getElementById('footer').clientHeight;

		// Work out when the button will display (i.e., float up from bottom)
		// scollHeight (height of document content - window height) minus 100px
		// var btnActivate = (scrollHeight - clientHeight) -100;

		if(scrollTop > 100){
			$('#btn-back').css('bottom', clientHeight/2);
		} else {
			$('#btn-back').css('bottom', '-100px');
		}


		if(scrollTop > 100){
			$('#btn-top').css('bottom', clientHeight/2);
		} else {
			$('#btn-top').css('bottom', '-100px');
		}
		
	}

	// Initiate and run the btn-back function() ...
	window.addEventListener('scroll', backButtons, false);

	/**************************************************************/


	// Scrolls to anchor position
	$(document).ready(function (){
		if($("#topic-title").length) { 
			$('html, body').animate({
				scrollTop: $("#topic-title").offset().top
			}, 600);
		}
	});

	// Scrolls to very top of page
	$(document).ready(function (){
		$("#btn-top").click(function (){
			$('html, body').animate({
				scrollTop: $("body").offset().top
			}, 600);
		});
	});


})();
