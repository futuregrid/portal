<?php

function fg_phase_2_inca_help_block() {
		$block['subject'] = t('INCA Dashboard Help');
		$block['content'] = t('To customize your dashboard, add a block by clicking the "Add a block" link above, click the asterisk (*) in the title bar to add a service to monitor, and submit the service form.');
		return $block;
}

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
		//$block['content'] = drupal_get_form('fg_phase_2_inca_status_block_form', $test_suite, $fg_system);
		$block['content'] = t('Click the asterisk (*) in the title bar to add a service to monitor.');
	}
	
	drupal_add_css(drupal_get_path('module','fg_phase_2').'/css/fg_inca.css');
	return $block;
}

function fg_phase_2_inca_status_block_form(&$form_state, $test_suite, $fg_system) {
	$form = array(
		'#attributes' => array('class' => 'fg-inca-form'),
	);
	

	if ($test_suite) {
		$form['test_suite'] = array(
			'#type' => 'hidden',
			'#value' => $test_suite,
		);
	}

	if ($fg_system) {
		$form['fg_system'] = array(
			'#type' => 'hidden',
			'#value' => $fg_system,
		);
	}
	
	$form['test-result'] = array('#value'=>'<div class="test-result"></div>');
	
	drupal_add_js(drupal_get_path('module','fg_phase_2').'/js/fg_inca_block.js');
	
	return $form;
}

function fg_phase_2_ganglia_block($config) {
	$block['subject'] = t('Ganglia Status');
	$block['content'] = t('This is the ganglia status');

	$title = t('Ganglia');
	$metric = "";
	$report_type = "";
	$cluster = "";
	$period = "";

	if ($config && $config['homebox']) {
		if ($config['homebox']->metric) {
			$metric = $config['homebox']->metric;
		}
		/**
		if ($config['homebox']->report_type) {
			$report_type = $config['homebox']->report_type;
		}
		**/
		if ($config['homebox']->cluster) {
			$cluster = $config['homebox']->cluster;
		}
		if ($config['homebox']->period) {
			$period = $config['homebox']->period;
		}
		if ($config['homebox']->node) {
			$node = $config['homebox']->node;
		} else {
			if ((($metric && $node) || $report_type) && $cluster && $period) {

			}
		}
	}
	
	
	$block = array();
	$block['subject'] = $title;
	drupal_set_message("metric: " . $metric . ", node: " . $node . ", report type: " . $report_type . ", cluster: " . $cluster . ", period: " . $period);
	if ($metric && $cluster && $period) {
		$block['content'] = fg_phase_2_get_ganglia_graph($node, $report_type, $cluster, $period);
	} else {
		$block['content'] = t('Click the asterisk (*) in the title bar to add a service to monitor.');
	}

	return $block;
}

function fg_phase_2_ganglia_block_form(&$form_state, $metric, $cluster, $period, $node) {
	if ($metric) {
		$form['metric'] = array(
			'#type' => 'hidden',
			'#value' => $metric,
		);
	}

	if ($node) {
		$form['node'] = array(
			'#type' => 'hidden',
			'#value' => $node,
		);
	}
/**
	if ($report_type) {
		$form['report_type'] = array(
			'#type' => 'hidden',
			'#value' => $report_type,
		);
	}
**/
	if ($cluster) {
		$form['cluster'] = array(
			'#type' => 'hidden',
			'#value' => $cluster,
		);
	}
	
	if ($period) {
		$form['period'] = array(
			'#type' => 'hidden',
			'#value' => $period,
		);
	}

	$form['ganglia-result'] = array('#value'=>'<div class="ganglia-result"></div>');
	
	drupal_add_js(drupal_get_path('module','fg_phase_2').'/js/fg_ganglia_block.js');
	
	return $form;
}
