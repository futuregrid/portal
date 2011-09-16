<?php

function fg_phase_2_inca_status_block($config) {
// 	$xml = file_get_contents("http://inca.futuregrid.org:8080/inca/XML/rest/Cloud/FG_CLOUD");
// 	$parser = xml_parser_create();
// 	$doc = new DOMDocument();

	$title = t('INCA Status');
	$test_suite = '';
	$fg_system = '';
	if ($config && $config['homebox']) {
		if ($config['homebox']->title) {
			$title = $config['homebox']->title;
		}
		if ($config['homebox']->test_suite) {
			$test_suite = $config['homebox']->test_suite;
		}
		if ($config['homebox']->fg_system) {
			$fg_system = $config['homebox']->fg_system;
		}
	}
	
	$block = array();
	$block['subject'] = $title;
	$block['content'] = '';
	if (!($test_suite && $fg_system)) {
		$block['content'] .= drupal_get_form('fg_phase_2_inca_status_block_form', empty($test_suite), empty($fg_system));
	}
	
	$block['content'] .= '<a class="suite">'.$test_suite.'</a>';
	$block['content'] .= '<a class="system">'.$fg_system.'</a>';
	
	return $block;
}

function fg_phase_2_inca_status_block_form(&$form_state, $show_suites = TRUE, $show_systems = TRUE) {
	$form = array(
		'#attributes' => array('class' => 'fg-inca-form'),
	);
	
	if ($show_suites) {
		$form['test_suite'] = array(
			'#type' => 'select',
			'#title' => t('INCA test suite'),
			'#options' => fg_phase_2_inca_suite_options(),
			'#default_value' => $form_state['values']['test_suite'],
		);
	}
  
	if ($show_systems) {
		$form['fg_system'] = array(
			'#type' => 'select',
			'#title' => t('System'),
			'#options' => fg_phase_2_fg_system_options(),
			'#default_value' => $form_state['values']['fg_system'],
		);
	}
	
	drupal_add_js(drupal_get_path('module','fg_phase_2').'/js/fg_inca_block.js');
	
	return $form;
}