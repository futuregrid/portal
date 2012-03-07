(function($) {
	$(document).ready(function() {
		if ($('.view-front-page-carousel .views-row').length > 1) {
			var $nav = $('<div class="carousel-nav">');
			$('.view-front-page-carousel').before($nav);
			$('.view-front-page-carousel')
				.scrollable({circular:true, items:'.view-content',easing:'easeOutExpo'})
				.autoscroll({interval:5000})
				.navigator({navi:'.carousel-nav'});
		}
	});
})(jQuery);
