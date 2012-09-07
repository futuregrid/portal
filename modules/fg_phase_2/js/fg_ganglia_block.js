Drupal.behaviors.fg_phase_2_ganglia_block_form = function(context) {

	$('.metric').bind('change', function() {
		console.log("Changed metric");
		if ($(this).val()) {
			$(this).parent('div').prev('div').prev('div').hide();
		} else {
			$(this).parent('div').prev('div').prev('div').show();
		}
	});

	$('.report_type').bind('change', function() {
		console.log("Changed report type.");
		if ($(this).val()) {
			$(this).parent('div').next('div').next('div').hide();
		} else {
			$(this).parent('div').next('div').next('div').show();
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

					nextDiv = thisCluster.parent('div').next('div').next('div').next('div').next('div');
					nextDiv.find('.node option').remove();

					$.each(options, function(key, value) {
						nextDiv.find('.node').append("<option value = '" + key + "'>" + value + "</option>");
					});
				}
			});
		} else {
			$(this).parent('div').next('div').next('div').next('div').next('div').next('div').hide();
			$(this).parent('div').next('div').next('div').next('div').next('div').hide();
			$(this).parent('div').next('div').next('div').next('div').hide();
			$(this).parent('div').next('div').hide();
		}
	});

	$('.node').bind('change', function() {
		if ($(this).val()) {
			var thisNode = $(this);
			$.ajax({
				type: "POST",
				url: "ajax-callback/" + thisNode.parent('div').prev('div').prev('div').prev('div').prev('div').find('.cluster').val() + "/" + $(this).val(),
				success: function (resp) {
					var options = Drupal.parseJson(resp);

					nextDiv = thisNode.parent('div').next('div');
					nextDiv.find('.metric option').remove();

					$.each(options, function(key, value) {
						//console.log(key + ": " + value);
						nextDiv.find('.metric').append("<option value = '" + key + "'>" + value + "</option>");
					});

					nextDiv.show();
					thisNode.parent('div').prev('div').show();
					thisNode.parent('div').prev('div').prev('div').prev('div').show();
				}
			});
		} else {
			$(this).find('.metric').parent().hide();
			$(this).find('.report-type').parent().hide();
			$(this).find('.period').parent().hide();
		}
	});
}
