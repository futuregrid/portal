Drupal.behaviors.fg_phase_2_ganglia_block_form = function(context) {

	if ($('#edit-cluster').val() == "") { 
		$('#edit-metric-wrapper').hide();
		$('#edit-node-wrapper').hide();
		$('#edit-report-type-wrapper').hide();
		$('#edit-report-period').hide();
	}

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

	$('#edit-cluster').bind('change', function() {
		if ($('#edit-cluster').val()) {
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + $('#edit-cluster').val() + "/null",
				success: function (resp) {
					var options = Drupal.parseJson(resp);
					
					$.each(options, function(key, value) {
						var output = "<option value = '" + key + "'>" + value + "</option>";
						$('#edit-node').append(output);
					});

					$('#edit-node-wrapper').show();
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
				url: "ajax-callback/" + $('#edit-cluster').val() + "/" + $('#edit-node option:selected').text(),
				success: function (resp) {
					var options = Drupal.parseJson(resp);
					
					$.each(options, function(key, value) {
						var output = "<option value = '" + key + "'>" + value + "</option>";
						$('#edit-metric').append(output);
					});

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
