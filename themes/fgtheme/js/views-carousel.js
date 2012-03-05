(function($) {
	$(document).ready(function() {
		var $nav = $('<div class="carousel-nav">');
		$('.view-front-page-carousel').before($nav);
		$('.views-field-title').before('<div class="views-field-title-background">');
		$('.view-front-page-carousel')
			.scrollable({circular:true, items:'.view-content',easing:'easeOutExpo'})
			.autoscroll({interval:5000})
			.navigator({navi:'.carousel-nav'});
	});
})(jQuery);