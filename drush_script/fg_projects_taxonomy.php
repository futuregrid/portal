#!/usr/bin/env drush

<?php
/**
	As will become obvious quickly, this is a one-off script, intended to be run ONLY ONCE
	to solve a very specific problem. The error checking is mostly non-existant. 

**/
$keywords_query = db_query("SELECT field_project_keywords_value from {content_type_fg_projects}");
$keywords_vocab = db_fetch_object(db_query("SELECT vid FROM {vocabulary} WHERE name = 'Project Keywords'"));

$titles_query = db_query("SELECT title FROM {node} WHERE type = 'fg_projects'");
$titles_vocab = db_fetch_object(db_query("SELECT vid FROM {vocabulary} WHERE name = 'Projects'"));

// if there are no vids, that means the vocabs don't exist. create these first.
if (!$keywords_vocab->vid) { 
	$keywords_vocab = new stdClass();
	$keywords_vocab->name = "Project Keywords";
	$keywords_vocab->description = "A list of keywords that describe your project";
	$keywords_vocab->help = "What keywords describe your project?";
	$keywords_vocab->relations = 1;
	$keywords_vocab->hierarchy = 0; 
	$keywords_vocab->multiple = 0; 
	$keywords_vocab->required = 1; 
	$keywords_vocab->tags = 1; 
	$keywords_vocab->module = "taxonomy";
	$keywords_vocab->weight = 0;
	drupal_write_record('vocabulary',$keywords_vocab);
}

if (!$titles_vocab->vid) {
	$titles_vocab = new stdClass();
	$titles_vocab->name = "Projects";
	$titles_vocab->description = "The title of your project.";
	$titles_vocab->help = "Enter the title of your project";
	$titles_vocab->relations = 1;
	$titles_vocab->hierarchy = 0; 
	$titles_vocab->multiple = 0; 
	$titles_vocab->required = 1; 
	$titles_vocab->tags = 1; 
	$titles_vocab->module = "taxonomy";
	$titles_vocab->weight = 0;
	drupal_write_record('vocabulary',$titles_vocab);
}

// we pull all the keywords already in the database...it's a comma-deliniated list, so we need to explode and loop over the values
// we also "clean" the keyword by lower-casing and trimming it so they're uniform
// if the term doesn't already exist, we insert it (this hopefully eliminates the majoritiy of duplicates)
while ($keywords = db_fetch_object($keywords_query)) {
	foreach(explode(',',$keywords->field_project_keywords_value) as $keyword) {
		$clean_word = strtolower(trim($keyword));
		$selected_keyword = db_fetch_array(db_query("SELECT name FROM {term_data} WHERE vid = %d AND name = '%s'",$keywords_vocab->vid,$clean_word));
		if (empty($selected_keyword) && $clean_word != '') {
			$new_keyword = new stdClass();
			$new_keyword->name = $clean_word;
			$new_keyword->vid = $keywords_vocab->vid;
			$new_keyword->description = '';

			drupal_write_record('term_data', $new_keyword);

			$new_rel = new stdClass();
			$new_rel->tid = $new_keyword->tid;
			$new_rel->parent = 0;

			drupal_write_record('term_hierarchy', $new_rel); 
		}
	}
}

// titles is easier....just create the new term (we're *assuming* all the titles are unique...
while ($title = db_fetch_object($titles_query)) {
	$new_title = new stdClass();
	$new_title->name = $title->title;
	$new_title->vid = $titles_vocab->vid;
	$new_title->description = '';

	drupal_write_record('term_data', $new_title);

	$new_rel = new stdClass();
	$new_rel->tid = $new_title->tid;
	$new_rel->parent = 0;

	drupal_write_record('term_hierarchy', $new_rel); 
}
?>
