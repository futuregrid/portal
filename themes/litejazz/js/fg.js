(function($) {
	$(document).ready(function() {
		var $searchForm = $('#search-block-form'),
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
	});
})(jQuery);