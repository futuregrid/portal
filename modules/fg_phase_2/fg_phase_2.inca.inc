<?php
function fg_phase_2_inca_suite_options() {
	return array(
  	'' => 'Show option',
  	'Basic' => 'Basic',
  	'Services' => 'Services',
  	'Grid' => 'Grid',
  	'HPC' => 'HPC',
  	'HPC_Tests' => 'HPC Tests',
  	'Benchmarks' => 'Benchmarks',
  	'Cloud' => 'Cloud',
  	'Modules' => 'Modules',
  	'Storage' => 'Storage',
  	'Inca' => 'Inca',
  );
}

function fg_phase_2_fg_system_options() {
	return array(
  	'' => 'Show option',
  	'iu-india' => 'India',
  	'iu-xray' => 'Xray',
  	'tacc-alamo' => 'Alamo',
  	'uc-hotel' => 'Hotel',
  	'ucsd-sierra' => 'Sierra',
  	'ufl-foxtrot' => 'Foxtrot',
  );
}

function fg_phase_2_fg_system_name($machine_name) {
	$systems = fg_phase_2_fg_system_options();
	return $systems[$machine_name];
}

function _fg_phase_2_get_inca_tests($test_suite) {
	switch ($test_suite) {
	case "Cloud":
		$tests = array(
			'eucalyptus-clientStatus',
			'eucalyptus-create-privatevm',
			'eucalyptus-create-publicvm',
			'eucalyptus-storage',
			'eucalyptus-usage-exceeded',
			'eucalyptus-webpage-loads',
			'nimbus-clientStatus',
			'nimbus-create-privatevm',
			'nimbus-create-publiccluster',
			'nimbus-create-publicvm',
			'nimbus-external-telnet',
			'nimbus-hostcert',
			'nimbus-storage',
			'openstack-clientStatus',
			'openstack-create-publicvm',
			'openstack-storage',
		);
		break;
	case "HPC":
		$tests = array(
			'gcc',
			'impi',
			'moab',
			'modules',
			'openmpi',
			'papi',
			'pgcc',
			'torque',
			'xcat',
		);
		break;
	default:
		$tests = array();
	}
	return $tests;
}

function fg_phase_2_get_inca_test($test_suite, $resourceId, $ajax = '') {
	$xmlstr = file_get_contents("http://inca.futuregrid.org:8080/inca/XML/rest/$test_suite/$resourceId");
	$xml = simplexml_load_string($xmlstr);
	$reports = json_decode(json_encode($xml));
	
	$series = array();
	foreach ($reports->reportSummary as $report) {
		$nickname = explode('_to_', $report->nickname);
		$series[$nickname[0]] = $report;
	}
	$output = theme("fg_inca_status_$test_suite", _fg_phase_2_get_inca_tests($test_suite), $series);
	if ($ajax != '') {
		drupal_json(array(
			'test' => $output,
			'title' => $test_suite.': '.fg_phase_2_fg_system_name($resourceId),
		));
	} else {
		return $output;
	}
}

function fg_phase_2_inca_theme() {
	return array(
		'fg_inca_status_Cloud' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Cloud'
		),
		'fg_inca_status_HPC' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_HPC'
		),
	);
}