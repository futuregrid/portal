(function($) {
	$(document).ready(function() {
		var $nav = $('<div class="carousel-nav">');
		$('.view-front-page-carousel').before($nav);
		$('.view-front-page-carousel')
			.scrollable({circular:true, items:'.view-content',easing:'easeOutExpo'})
			.autoscroll({interval:5000})
			.navigator({navi:'.carousel-nav'});
	});
})(jQuery);