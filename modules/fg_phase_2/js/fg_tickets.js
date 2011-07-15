Drupal.behaviors.fg_tickets = function(context) {
	function getTicket(header, body) {
		if ($(body).children().length == 0) {
			var tid = $('.ticket-id',header);
			$(body).html('<div class="loading">Loading ticket details...</div>');
			$.ajax({
				"url": tid.attr('href') + '/ajax',
				"dataType": "json",
				"success": function(resp) {
					$(body).html(resp["view"]);
				},
				"error": function() {
					$(body).html("<p>There was an error loading the ticket information.</p>");
				}
			});
		}
	}
	
	var tids = $('.ticket-id',context);
	if (tids.length > 0) {
		var tab = $('#my-tickets');
		var dtab = tab.dataTable({
			"aaSorting":[[1,'desc']],
			"sDom":'lf<"clear space">t<"clear space">ip<"clear">',
			"sPaginationType":"full_numbers"
		});
		$('.fg-loading').fadeIn();
		var len = tids.length;
		tids.each(function(i,o) {
			var tid = $(o);
			tid.addClass("processed");
			$.ajax({
				"url":$(o).attr("href"),
				"dataType":"json",
				"success":function(resp) {
					dtab.fnAddData([
						resp["viewUrl"],
						resp["data"]["Created"],
						resp["data"]["Subject"],
						resp["data"]["Status"],
						resp["data"]["LastUpdated"]
					]);
					len -= 1;
				},
				"complete":function() {
					if (len == 0) {
						$(".fg-loading").fadeOut();
					}
					Drupal.attachBehaviors(tab.find("tbody"));
				}
			});
		});
	}	
}

Drupal.behaviors.fg_ticket_view = function(context) {
	$('.ticket-view-link:not(.processed)',context).bind('click',
		function() {
			$.ajax({
				"url":$(this).attr("href"),
				"dataType":"json",
				"beforeSend":function() {
					$(".fg-loading").html("Loading ticket details...").fadeIn();
				},
				"success":function(resp) {
					$("<div>").html(resp["view"]).dialog({
						"title":resp["title"],
						"width":800,
						"height":600
					});
				},
				"error":function() {
					$("<div>Error loading ticket history.</div>").dialog();
				},
				"complete":function() {
					$(".fg-loading").fadeOut();
				}
			});
			return false;
		}
	).addClass("processed");
}