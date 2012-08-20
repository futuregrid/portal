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

					nextDiv = thisCluster.parent('div').next('div');
					nextDiv.find('.node option').remove();
					nextDiv.find('.node').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						nextDiv.find('.node').append("<option value = '" + key + "'>" + value + "</option>");
					});
				}
			});
		} else {
			$(this).parent('div').next('div').find('.metric').parent().hide();
			$(this).parent('div').next('div').find('.node').parent().hide();
			$(this).parent('div').next('div').find('.report-type').parent().hide();
			$(this).parent('div').next('div').find('.period').parent().hide();
		}
	});

	$('.node').bind('change', function() {
		if ($(this).val()) {
			var thisNode = $(this);
			var nodeOptionSelected = $(this + ' option: selected');
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + thisNode.parent('div').prev('div').find('.cluster').val() + "/" + nodeOptionSelected.text(),
				success: function (resp) {
					var options = Drupal.parseJson(resp);

					nextDiv = thisNode.parent('div').next('div');
					nextDiv.find('.metric option').remove();
					nextDiv.find('.metric').append("<option value = ''>Show option</option>");

					$.each(options, function(key, value) {
						//console.log(key + ": " + value);
						nextDiv.find('.metric').append("<option value = '" + key + "'>" + value + "</option>");
					});

					nextDiv.find('.metric').parent().show();
					nextDiv.find('.report-type').parent().show();
					nextDiv.find('.period').parent().show();
				}
			});
		} else {
			$(this).find('.metric').parent().hide();
			$(this).find('.report-type').parent().hide();
			$(this).find('.period').parent().hide();
		}
	});
}
