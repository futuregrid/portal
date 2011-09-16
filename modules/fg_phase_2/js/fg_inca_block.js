Drupal.behaviors.fg_phase_2_inca_block_form = function(context) {
	function doUpdate(tests, systems) {
		if (tests && systems) {
			$.ajax({
				url: Drupal.settings.base_path + 'fg/inca/xml/' + tests + '/' + systems,
				success: function() {
					alert('yay!');
				}
			});
		}
	}
	$('.fg-inca-form').each(function() {
		var $form = $(this);
		
		$('select[name=test_suite]', $form).bind('change', function() {
			$('a.suite', $form.parent()).text($(this).val());
			doUpdate($('a.suite').text(), $('a.system').text());
		});
		
		$('select[name=fg_system]', $form).bind('change', function() {
			$('a.system', $form.parent()).text($(this).val());
			doUpdate($('a.suite').text(), $('a.system').text());
		});
		
	});
}