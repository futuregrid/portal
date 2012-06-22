Drupal.behaviors.fg_phase_2_ganglia_block_form = function(context) {
	$('#edit-metric').bind('change', function() {
		if ($('#edit-metric').val()) {
			$('#edit-report-type-wrapper').hide();
		} else {
			$('#edit-report-type-wrapper').show();
		}
	});

	$('#edit-report-type').bind('change', function() {
		if ($('#edit-report-type').val()) {
			$('#edit-metric-wrapper').hide();
			$('#edit-node-wrapper').hide();
		} else {
			$('#edit-metric-wrapper').show();
			$('#edit-node-wrapper').show();
		}
	});
		

}
