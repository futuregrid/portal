(function($) {
	$(document).ready(function() {
		if ($('.view-front-page-carousel .views-row').length > 1) {
			$('.view-front-page-carousel').before('<div class="play-pause">').before('<div class="carousel-nav">');
			$('.view-front-page-carousel')
				.scrollable({circular:true, items:'.view-content',easing:'easeOutExpo'})
				.autoscroll({interval:5000,autopause:false})
				.navigator({navi:'.carousel-nav'});
			
			var scrollableApi = $('.view-front-page-carousel').data("scrollable");
			$('.play-pause').addClass('playing').attr('title','Click to pause').bind('click', function() {
				var self = $(this);
				if (self.hasClass('playing')) {
					self.removeClass('playing').attr('title','Click to play');
					scrollableApi.stop();
				} else {
					self.addClass('playing').attr('title','Click to pause');
					scrollableApi.play();
				}
			});
		}
	});
})(jQuery);
