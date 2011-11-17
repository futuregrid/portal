<?php

function fg_phase_2_inca_status_block($config) {
	$title = t('INCA Status');
	$test_suite = '';
	$fg_system = '';
	if ($config && $config['homebox']) {
		if ($config['homebox']->test_suite) {
			$test_suite = $config['homebox']->test_suite;
		}
		if ($config['homebox']->fg_system) {
			$fg_system = $config['homebox']->fg_system;
		}
		if ($config['homebox']->title) {
			$title = $config['homebox']->title;
		} else {
			if ($fg_system && $test_suite) {
				$title = $test_suite.": ".fg_phase_2_fg_system_name($fg_system);
			} else if ($fg_system) {
				$title = fg_phase_2_fg_system_name($fg_system) . " INCA Status";
			} else if ($test_suite) {
				$title = "INCA $test_suite Status";
			}
		}
	}
	
	
	$block = array();
	$block['subject'] = $title;
	if ($test_suite && $fg_system) {
		$block['content'] = fg_phase_2_get_inca_test($test_suite, $fg_system);
	} else {
		$block['content'] = drupal_get_form('fg_phase_2_inca_status_block_form', $test_suite, $fg_system);
	}
	
	drupal_add_css(drupal_get_path('module','fg_phase_2').'/css/fg_inca.css');
	return $block;
}

function fg_phase_2_inca_status_block_form(&$form_state, $test_suite, $fg_system) {
	$form = array(
		'#attributes' => array('class' => 'fg-inca-form'),
	);
	
	if (! $test_suite) {
		$form['test_suite'] = array(
			'#type' => 'select',
			'#title' => t('INCA test suite'),
			'#options' => fg_phase_2_inca_suite_options(),
			'#default_value' => $form_state['values']['test_suite'],
		);
	} else {
		$form['test_suite'] = array(
			'#type' => 'hidden',
			'#value' => $test_suite,
		);
	}

	if (! $fg_system) {
		$form['fg_system'] = array(
			'#type' => 'select',
			'#title' => t('System'),
			'#options' => fg_phase_2_fg_system_options(),
			'#default_value' => $form_state['values']['fg_system'],
		);
	} else {
		$form['fg_system'] = array(
			'#type' => 'hidden',
			'#value' => $fg_system,
		);
	}
	
	$form['test-result'] = array('#value'=>'<div class="test-result"></div>');
	
	drupal_add_js(drupal_get_path('module','fg_phase_2').'/js/fg_inca_block.js');
	
	return $form;
}