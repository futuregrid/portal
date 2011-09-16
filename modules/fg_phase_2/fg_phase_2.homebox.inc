<?php

function fg_phase_2_homebox() {
	$pages = array();
	$pages['fg_inca_status'] = array(
		'title' => 'FG INCA Status',     // The title of the Homebox page
    'path' => 'fg_inca_status',            // The path of the Homebox (URL)
    'menu' => 0,                    // Add a menu entry for this page (Navigation)
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
      1 => 25,
      2 => 50,
      3 => 25,
    ),
    'blocks' => array(              // The available blocks on the page
      'fg_phase_2_0' => array(            // The block key; Format = module_delta
        'module' => 'fg_phase_2',         // The module this block belongs to
        'delta' => '0',             // The block delta
        'region' => 1,              // Which region to place this block in
        'movable' => 1,             // Can this block be dragged?
        'status' => 1,              // Is this block visible by default (if not, it can be toggled)?
        'open' => 1,                // Is this block expanded by default?
        'closable' => 1,            // Can users close this block?
        'title' => '',              // Blank if default block title should be used, if not, use a custom one
        'weight' => -8,             // The weight of the block (smaller numbers raise to the top)
        'test_suite' => '',
        'fg_system' => '',
      ),
    )
	);
	return $pages;
}

function fg_phase_2_homebox_block_keys($block) {
  return array('title', 'test_suite', 'fg_system');
}

function fg_phase_2_homebox_block_edit_form($block) {
	$form = array();
	$form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#size' => 25,
    '#default_value' => $block->title,
  );
  
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
  
  return $form;
}