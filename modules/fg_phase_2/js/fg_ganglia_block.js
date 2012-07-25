Drupal.behaviors.fg_phase_2_ganglia_block_form = function(context) {

	$('#edit-metric-wrapper').hide();
	$('#edit-node-wrapper').hide();
	$('#edit-report-type-wrapper').hide();
	$('#edit-report-period').hide();

	$('#edit-metric').bind('change', function() {
		if ($('#edit-metric').val()) {
			$('#edit-report-type-wrapper').hide();

			$.ajax({
				type: "POST",
				url: "../fg_phase_2.inca.inc",
				data: {
					metric: $('#edit-metric').val()
				}
			});
		} else {
			$('#edit-report-type-wrapper').show();
		}
	});

	$('#edit-report-type').bind('change', function() {
		if ($('#edit-report-type').val()) {
			$('#edit-metric-wrapper').hide();
			$('#edit-node-wrapper').hide();

			$.ajax({
				type: "POST",
				url: "../fg_phase_2.inca.inc",
				data: {
					report_type: $('#edit-metric').val()
				}
			});
		} else {
			$('#edit-metric-wrapper').show();
			$('#edit-node-wrapper').show();
		}

	});

	$('#edit-cluster').bind('change', function() {
		if ($('#edit-cluster').val()) {
			$.ajax({
				type: "POST",
				url: "../fg_phase_2.inca.inc",
				data: {
					cluster: $('#edit-cluster').val()
				}, 
				success: function (resp) {
					$('#edit-metric-wrapper').show();
					$('#edit-node-wrapper').show();
					$('#edit-report-type-wrapper').show();
					$('#edit-period-wrapper').show();
				}
			});
		} else {
			$('#edit-metric-wrapper').hide();
			$('#edit-node-wrapper').hide();
			$('#edit-report-type-wrapper').hide();
			$('#edit-period-wrapper').hide();
		}
	});

	$('#edit-node').bind('change', function() {
		if ($('#edit-node').val()) {
			$.ajax({
				type: "POST",
				url: "../fg_phase_2.inca.inc",
				data: {
					cluster: $('#edit-cluster').val(),
					node: $('#edit-node').val()
				}, 
				success: function (resp) {
					$('#edit-metric-wrapper').show();
					$('#edit-report-type-wrapper').show();
					$('#edit-period-wrapper').show();
				}
			});
		} else {
			$('#edit-metric-wrapper').hide();
			$('#edit-report-type-wrapper').hide();
			$('#edit-period-wrapper').hide();
		}
	});
}
