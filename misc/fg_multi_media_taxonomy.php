#!/usr/bin/env drush

<?php
/**
 *
 *	Rewritten from fg_projects_taxonomy. Just trying to save myself time. 
**/
$multi_media_query = db_query("SELECT n.nid from {content_type_multi_media} ctmm left join {node} n on (ctmm.nid = n.nid)");
$term = taxonomy_get_term_by_name("Science Cloud Summer School");

// we pull all the keywords already in the database...it's a comma-deliniated list, so we need to explode and loop over the values
// we also "clean" the keyword by lower-casing and trimming it so they're uniform
// if the term doesn't already exist, we insert it (this hopefully eliminates the majoritiy of duplicates)
while ($result = db_fetch_object($multi_media_query)) {
	$multi_media_node = node_load($result->nid);
	print "Loaded node: " . $multi_media_node->title . "\n";

	if (empty($multi_media_node->taxonomy)) {
		print "No term applied to node.\n";
		$multi_media_node->taxonomy[] = $term;
			//taxonomy_get_term_by_name("Science Cloud Summer School");
		//$term = taxonomy_get_term_by_name("Science Cloud Summer School");
		print "Applied taxonomy term: ";
	        print_r($term);
		print "\n";
		node_save($multi_media_node);
	} else if ($multi_media_node->taxonomy[0]['name'] != "Science Cloud Summer School") {
		print "TERM *******";
		print_r($term);
		print "TAX *******";
		print_r($multi_media_node->taxonomy);
	}
}
?>
