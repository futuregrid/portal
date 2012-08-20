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
			$(this).find('.report_type').parent().hide();
		} else {
			$(this).find('.report_type').parent().show();
		}
	});

	$('.report_type').bind('change', function() {
		if ($(this).val()) {
			$(this).find('.metric').parent().hide();
			$(this).find('.node').parent().hide();
		} else {
			$(this).find('.metric').parent().show();
			$(this).find('.node').parent().show();
		}

	});

	$('.cluster').bind('change', function() {
		if ($(this).val()) {
			var thisCluster = $(this);
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + $(this).val() + "/null",
				success: function (resp) {
					var options = Drupal.parseJson(resp);

					console.log(thisCluster.parent('div'));
					thisCluster.find('.node option').remove();
					thisCluster.find('.node').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						thisCluster.find('.node').append("<option value = '" + key + "'>" + value + "</option>");
					});

					thisCluster.find('.node').parent().show();
				}
			});
		} else {
			$(this).find('.metric').parent().hide();
			$(this).find('.node').parent().hide();
			$(this).find('.report-type').parent().hide();
			$(this).find('.period').parent().hide();
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

					$(this).find('.metric').parent().show();
					$(this).find('.report-type').parent().show();
					$(this).find('.period').parent().show();
				}
			});
		} else {
			$(this).find('.metric').parent().hide();
			$(this).find('.report-type').parent().hide();
			$(this).find('.period').parent().hide();
		}
	});
}
