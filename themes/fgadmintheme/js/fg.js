(function($) {
	$(document).ready(function() {
		// search foo
		var $searchForm = $('#edit-search-theme-form-1-wrapper'),
				$field = $('input[type=text]', $searchForm),
				label = 'Search FutureGrid...';
		$field.bind('focus', function() {
			var $this = $(this),
					val = $this.val();
			if (val == label) {
				$this.val('');
				$this.removeClass('prompt');
			}
		}).bind('blur', function() {
			var $this = $(this),
					val = $this.val();
			if (val == '') {
				$this.val(label);
				$this.addClass('prompt');
			}
		}).trigger('blur');
		$searchForm.bind('submit', function() {
			if ($field.val() == label) {
				$field.val('');
			}
		});
		
		// menu foo
		$('#navigation li').bind('mouseenter', function() {
			var $this = $(this);
			$.doTimeout('menu-hover', 50, function() {
				$this.siblings().removeClass('hover left').find('.hover').removeClass('hover left').end().end().addClass('hover');
				$childUl = $this.children('ul');
				if ($childUl.length > 0 && ($childUl.offset().left + $childUl.width()) > ($(window).scrollLeft() + $(window).width())) {
					$this.addClass('left');
				} else {
					$this.removeClass('left');
				}
			});
		}).bind('mouseleave', function() {
			var $this = $(this);
			$.doTimeout('menu-hover', 500, function() {
				$this.removeClass('hover').find('.hover').removeClass('hover');
			});
		});

		// messages
		$('.messages.warning, .messages.status, .messages.success').attr('title', 'Click to dismiss').bind('click', function() {
			var $this = $(this);
			$this.fadeOut(function() {$this.remove()});
		});

	});	
})(jQuery);