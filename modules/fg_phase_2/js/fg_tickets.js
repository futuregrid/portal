Drupal.behaviors.fg_tickets = function(context) {
	function getTicket(header, body) {
		if ($(body).children().length == 0) {
			var tid = $('.ticket-id',header);
			$(body).html('<div class="loading">Loading ticket details...</div>');
			$.ajax({
				"url": tid.attr('href'),
				"dataType": "json",
				"success": function(resp) {
					$(body).html(resp["products"]);
				},
				"error": function() {
					$(body).html("<p>There was an error loading the ticket information.</p>");
				}
			});
		}
	}
	
	$('.tickets-accordion', context).accordion({
		"autoHeight": false,
		"collapsible": true,
		"active": false,
		"changestart": function(e,ui) { getTicket(ui.newHeader, ui.newContent); },
		"create": function(e,ui) { getTicket(ui.newHeader, ui.newContent); }
	});
}