(function($) {
	$(document).ready(function () {
		$('.accordion .pane-content > .menu').accordion({
			event: "mouseover",
			autoHeight: false
		});
	});
})(jQuery);