#!/usr/bin/env drush

<?php
$keywords_query = db_query("SELECT field_project_keywords_value from {content_type_fg_projects}");
$keyword_vid = db_fetch_object(db_query("SELECT vid FROM {vocabulary} WHERE name = 'Project Keywords'"));

$titles_query = db_query("SELECT title FROM {node} WHERE type = 'fg_projects'");
$titles_vid = db_fetch_object(db_query("SELECT vid FROM {vocabulary} WHERE name = 'Projects'"));
//insert all titles

while ($keywords = db_fetch_object($keywords_query)) {
	foreach(explode(',',$keywords->field_project_keywords_value) as $keyword) {
		$clean_word = strtolower(trim($keyword));
		$selected_keyword = db_fetch_array(db_query("SELECT name FROM {term_data} WHERE vid = %d AND name = '%s'",$keyword_vid->vid,$clean_word));
		if (empty($selected_keyword)) {
			$new_keyword = new stdClass();
			$new_keyword->name = $clean_word;
			$new_keyword->vid = $keyword_vid->vid;
			$new_keyword->description = '';

			drupal_write_record('term_data', $new_keyword);

			$new_rel = new stdClass();
			$new_rel->tid = $new_keyword->tid;
			$new_rel->parent = 0;

			drupal_write_record('term_hierarchy', $new_rel); 
		}
	}
}

while ($title = db_fetch_object($titles_query)) {
	$new_title = new stdClass();
	$new_title->name = $title->title;
	$new_title->vid = $titles_vid->vid;
	$new_title->description = '';

	drupal_write_record('term_data', $new_title);

	$new_rel = new stdClass();
	$new_rel->tid = $new_title->tid;
	$new_rel->parent = 0;

	drupal_write_record('term_hierarchy', $new_rel); 
}

?>
