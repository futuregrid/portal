<?php

function iukb_drush_command() {
	$items = array();
	
	$items['iukb-set-default-alias'] = array(
		'callback' => 'iukb_set_default_path_alias',
		'description' => 'Reset all Knowledge Base nodes url alias to the default "kb/document/[kb_doc_id]"',
		'aliases' => array('iukbalias'),
	);
	
	return $items;
}


function iukb_set_default_path_alias() {
	if (module_exists("path")) {
		$result = db_query("SELECT nid FROM {node} WHERE type = '%s'", 'iukb');
		while ($nid = db_result($result)) {
			db_query("DELETE FROM {url_alias} WHERE src = '%s'", "node/$nid");
			$kbInfo = iukb_get_kb_info($nid);
			path_set_alias("node/$nid", "kb/document/".$kbInfo->iukb_docid);
		}
	}
}