<?php 

function fgutil_drush_command() {
	$items = array();
	
	$items['fgutil-force-username'] = array(
		'callback' => 'fgutil_force_username',
		'description' => 'Force a username change in the portal. This circumvents any external/LDAP validation checks on the username. USE WITH CAUTION.',
		'aliases' => array('fgforceuser'),
		'arguments' => array(
			'oldUsername' => 'The user\'s current username in Drupal portal',
			'newUsername' => 'The new username to assign to the user'
		),
	);
	
	return $items;
}

function fgutil_force_username($oldUsername, $newUsername) {
	drush_log(dt('Updating username for user %old to %new', array('%old' => $oldUsername, '%new' => $newUsername)));
	
	$result = db_query("UPDATE {users} SET name = '%s' WHERE name = '%s'", $newUsername, $oldUsername);
	
	if (db_affected_rows() == 1) {
		drush_log(dt('Username for user %old successfully changed to %new', array('%old' => $oldUsername, '%new' => $newUsername)), 'success');
	} else {
		drush_log(dt('Username change for user %old failed', array('%old' => $oldUsername)), 'error');
	}
}