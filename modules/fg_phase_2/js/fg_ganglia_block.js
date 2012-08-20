Drupal.behaviors.fg_phase_2_ganglia_block_form = function(context) {

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

	$('.metric').bind('change', function() {
		if ($(this).val()) {
			$(this).next('.report_type').hide();
		} else {
			$(this).next('.report_type').show();
		}
	});

	$('.report_type').bind('change', function() {
		if ($(this).val()) {
			$(this).next('.metric').hide();
			$(this).next('.node').hide();
		} else {
			$(this).next('.metric').show();
			$(this).next('.node').show();
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

					$(this).next('.node option').remove();
					$(this).next('.node').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						$(this).next('.node').append("<option value = '" + key + "'>" + value + "</option>");
					});

					$(this).next('.node').show();
				}
			});
		} else {
			$(this).next('.metric').hide();
			$(this).next('.node').hide();
			$(this).next('.report-type').hide();
			$(this).next('.period').hide();
		}
	});

	$('.node').bind('change', function() {
		if ($(this).val()) {
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + $(this).next('.cluster').val() + "/" + $(this + ' option:selected').text(),
				success: function (resp) {
					var options = Drupal.parseJson(resp);

					$(this).next('.metric option').remove();
					$(this).next('.metric').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						//console.log(key + ": " + value);
						$(this).next('.metric').append("<option value = '" + key + "'>" + value + "</option>");
					});

					$(this).next('.metric').show();
					$(this).next('.report-type').show();
					$(this).next('.period').show();
				}
			});
		} else {
			$(this).next('.metric').hide();
			$(this).next('.report-type').hide();
			$(this).next('.period').hide();
		}
	});
}
