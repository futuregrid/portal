Drupal.behaviors.iukb_search_form = function(context) {
	$('#iukb-search-form input[type=submit]').bind('click', function() {
// 		var action = $('#iukb-search-form').attr('action').split("\?");
// 		$('#iukb-search-form').attr('action', action[0] + "?search=" + $('#edit-search').val());
	});
};