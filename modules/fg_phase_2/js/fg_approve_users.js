Drupal.behaviors.fg_approve_users = function(context) {
	$('.fg-approve-users-table').dataTable({
		"aaSorting":[[8,'asc']],
		"bInfo": false,
		"bPaginate": false,
		"sDom": 'f<"clear">t<"clear">'
	});
}