Drupal.behaviors.fg_phase_2_ganglia_block_form = function(context) {

	/**
	if ($('.cluster').val() == "") { 
		$('.node').hide();
		if ($('.report-type').val() != "") {
			$('.metric').hide();
		} else {
			$('.metric').show();
		}
		if ($('.metric').val() != "") {
			$('.report_type').hide();
		} else {
			$('.report_type').show();
		}
		$('.period').hide();
	}
	**/

	$('.metric').bind('change', function() {
		if ($(this).val()) {
			$(this).find('.report_type').hide();
		} else {
			$(this).find('.report_type').show();
		}
	});

	$('.report_type').bind('change', function() {
		if ($(this).val()) {
			$(this).find('.metric').hide();
			$(this).find('.node').hide();
		} else {
			$(this).find('.metric').show();
			$(this).find('.node').show();
		}

	});

	$('.cluster').bind('change', function() {
		console.log("Changed");
		if ($(this).val()) {
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + $(this).val() + "/null",
				success: function (resp) {
					var options = Drupal.parseJson(resp);

					$(this).find('.node option').remove();
					$(this).find('.node').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						$(this).find('.node').append("<option value = '" + key + "'>" + value + "</option>");
					});

					$(this).find('.node').show();
				}
			});
		} else {
			$(this).find('.metric').hide();
			$(this).find('.node').hide();
			$(this).find('.report-type').hide();
			$(this).find('.period').hide();
		}
	});

	$('.node').bind('change', function() {
		if ($(this).val()) {
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + $(this).find('.cluster').val() + "/" + $(this + ' option:selected').text(),
				success: function (resp) {
					var options = Drupal.parseJson(resp);

					$(this).find('.metric option').remove();
					$(this).find('.metric').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						//console.log(key + ": " + value);
						$(this).find('.metric').append("<option value = '" + key + "'>" + value + "</option>");
					});

					$(this).find('.metric').show();
					$(this).find('.report-type').show();
					$(this).find('.period').show();
				}
			});
		} else {
			$(this).find('.metric').hide();
			$(this).find('.report-type').hide();
			$(this).find('.period').hide();
		}
	});
}
