<?php

function fg_phase_2_homebox() {
	$pages = array();
	$pages['fg_inca_status'] = array(
		'title' => 'FutureGrid Inca Status',     // The title of the Homebox page
    'path' => 'futuregrid-inca-status',            // The path of the Homebox (URL)
    'menu' => 1,                    // Add a menu entry for this page (Navigation)
    'enabled' => 1,                 // Enable or disable the page. Only admins can view disabled
    'regions' => 3,                 // How many regions to create (1-9)
    'cache' => 0,                   // Use the block cache, when available
    'full' => 0,                    // Disable theme regions so page can go full-width
    'auto_save' => 1,
    'roles' => array(               // Which roles can view the page. If none specified, no one can view
      0 => 'authenticated user',
    ),
    'color' => 0,                   // Allow users to change the color of blocks
    'widths' => array(              // (Optional) The width percentage of each region
      1 => 33,
      2 => 34,
      3 => 33,
    ),
	);
	
	$blocks = array();
	$systems = fg_phase_2_fg_system_options();
	array_shift($systems);
	$region = 0;

	$blocks["fg_phase_2_1"] = array(
		'module' => 'fg_phase_2',
		'delta' => 1,
		'region' => $region + 1,
		'movable' => 1,
		'status' => 1,
		'open' => 1,
		'closable' => 1,
		'weight' => 0,
	);

	$blocks["fg_phase_2_0"] = array(
		'module' => 'fg_phase_2',
		'delta' => 0,
		'region' => $region + 1,
		'movable' => 1,
		'status' => 1,
		'open' => 1,
		'closable' => 1,
		'weight' => 0,
		'title' => "",
		'test_suite' => "",
		'fg_system' => "",
	);

	$blocks["fg_phase_2_2"] = array(
		'module' => 'fg_phase_2',
		'delta' => 2,
		'region' => $region + 1,
		'movable' => 1,
		'status' => 1,
		'open' => 1,
		'closable' => 1,
		'weight' => 0,
		'metric' => "",
		'report_type' => "",
		'cluster' => "",
		'period' => "",
		'node' => "",
	);

	$pages['fg_inca_status']['blocks'] = $blocks;
	
	return $pages;
}

function fg_phase_2_homebox_block_keys($block) {

	if ($block->delta == 2) {
  		return array('metric','report_type','cluster','period','node');
	} else {
  		return array('title', 'test_suite', 'fg_system');
	}
}

function fg_phase_2_homebox_block_edit_form($block) {
	$form = array();
 
	if ($block->delta == 2) {  

		$form['metric'] = array(
			'#type' => 'select',
			'#title' => t('Metrics'),
			'#options' => fg_phase_2_ganglia_metrics(),
			'#default_value' => $block->metric,
		);

		$form['node'] = array(
			'#type' => 'select',
			'#title' => t('Node'),
			'#options' => fg_phase_2_ganglia_node_list(),
			'#default_value' => $block->node,
		);

		$form['report_type'] = array(
			'#type' => 'select',
			'#title' => t('Report Type'),
			'#options' => fg_phase_2_ganglia_report_type(),
			'#default_value' => $block->report_type,
		);

		$form['cluster'] = array(
			'#type' => 'select',
			'#title' => t('System'),
			'#options' => fg_phase_2_ganglia_system_options(),
			'#default_value' => $block->cluster,
		);


		$form['period'] = array(
			'#type' => 'select',
			'#title' => t('Period'),
			'#options' => fg_phase_2_ganglia_period(),
			'#default_value' => $block->period,
		);

		drupal_add_js(drupal_get_path('module','fg_phase_2').'/js/fg_ganglia_block.js');

	} else {
		$form['test_suite'] = array(
			'#type' => 'select',
			'#title' => t('INCA test suite'),
			'#options' => fg_phase_2_inca_suite_options(),
			'#default_value' => $block->test_suite,
		);

		$form['fg_system'] = array(
			'#type' => 'select',
			'#title' => t('System'),
			'#options' => fg_phase_2_fg_system_options(),
			'#default_value' => $block->fg_system,
		);

	}
  return $form;
}
