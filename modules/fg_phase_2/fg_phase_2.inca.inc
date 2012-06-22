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

function fg_phase_2_ganglia_system_options() {
	return array(
  	'' => 'Show option',
  	'India' => 'India',
  	'Xray' => 'Xray',
  	'Alamo' => 'Alamo',
  	'Hotel' => 'Hotel',
  	'Sierra' => 'Sierra',
  	'Foxtrot' => 'Foxtrot',
  );
}

function fg_phase_2_ganglia_metrics() {
	return array(
		'' => 'Show option',
		'bytes_in' => 'Bytes In',
		'bytes_out' => 'Bytes Out',
		'cpu_aidle' => 'CPU Aidle',
		'cpu_idle' => 'CPU Idle',
		'cpu_nice' => 'CPU Nice',
		'cpu_system' => 'CPU System',
		'cpu_user' => 'CPU User',
		'cpu_wio' => 'CPU WIO',
		'disk_free' => 'Disk Free',
		'disk_total' => 'Disk Total',
		'load_fifteen' => 'Load Fifteen',
		'load_five' => 'Load Five',
		'load_one' => 'Load One',
		'mem_buffers' => 'Mem Buffers',
		'mem_cached' => 'Mem Cached',
		'mem_free' => 'Mem Free',
		'mem_shared' => 'Mem Shared',
		'part_max_used' => 'Part Max Used',
		'pkts_in' => 'PKTS In',
		'pkts_out' => 'PKTS Out',
		'proc_run' => 'Proc Run',
		'proc_total' => 'Proc Total',
		'swap_free' => 'Swap Free',
	);
}

function fg_phase_2_ganglia_period() {
	return array(
		'' => 'Show Option',
		'hour' => 'Hour',
		'day' => 'Day',
		'week' => 'Week',
		'year' => 'Year',
	);
}

function fg_phase_2_ganglia_report_type() {
	return array( 
		'' => 'Show Option',
		'load_report' => 'Load Report',
		'cpu_report' => 'CPU Report',
		'mem_report' => 'Mem Report',
		'network_report' => 'Network Report',
	);
}

function fg_phase_2_ganglia_node_list() {
	$sock = fsockopen("ganglia.futuregrid.org",8651);

	if ($sock) {
		$node_data = "";
		while (!feof($sock)) {
			$node_data .= fgets($sock, '1028');
		}
		fclose($sock);

		$nodes = simplexml_load_string($node_data);
		$node_options = array();
		foreach ($nodes->GRID->CLUSTER as $cluster) {
			foreach ($cluster->HOST->attributes() as $key => $value) {
				$node_set = array();
				if ($key == "NAME") {
					$node_set["NAME"] = $value;
				} else if ($key == "IP") {
					$node_set["IP"] = $value;
				}
				if (count($node_set) == 2) {
					drupal_set_message("<pre>" . print_r($node_set,1) . "</pre>");
					$node_options[$node_set["IP"]] = $node_set["NAME"];
				}
			}
		}

		//drupal_set_message("<pre>" . print_r($node_options,1) . "</pre>");
		return $node_options;
	}
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
	case "Basic":
		$tests = array(
			'ssh',
			'is_home_readwrite',
		);
		break;
	case "Services":
		$tests = array(
			'ganglia',
			'ganglia-server',
			'ganglia-server-pulldata',
			'inca',
			'jira',
			'ldap',
			'mongodb',
			'netlogger-eucalyptus',
			'netlogger-inca',
			'netlogger-nimbus',
			'netlogger-nova',
			'perfsonar-web',
			'portal',
			'portal-mail',
			'portal-outages-feed',
			'tickets',
			'tickets-mailserver',
			'tickets-testmail',
			'wiki',
		);
		break;
	case "Grid":
		$tests = array(
			'genesis-jobsubmit',
			'genesis-externel-telnet',
			'genesis-serverping',
			'genesis-clientauth',
			'globus-ca-crl-check-gridhost',
			'globus-ca-crl-check-login',
			'globus-gram-batch',
			'globus-gram-externel-telnet',
			'globus-gram-fork',
			'globus-gram-ping',
			'globus-gridftp-externel-telnet',
			'globus-gridftp-transfer',
			'globus-hostcert',
			'unicore-externel-telnet',
			'unicore-jobsubmit',
			'unicore-serverping',
		);
		break;
	case "HPC_Tests":
		$tests = array(
			'vampirtrace',
			'batch-testjob',
			'myhadoop',
		);
		break;
	case "Benchmarks":
		$tests = array(
			'hpcc8',
			'hpcc16',
			'hpcc32',
			'hpcc64',
			'hpcc128',
			'hpcc256',
		);
		break;
	case "Modules":
		$tests = array(
			'modules',
		);
		break;
	case "Storage":
		$tests = array(
			'diskcheck_nas-0-0',
			'diskcheck_nas-0-1',
			'infinibandPerf_nas-0-0ib',
			'infinibandPerf_nas-0-1ib',
			'is_images_exist',
			'is_nas-0-0ib_reachable',
			'is_nas-0-1ib_reachable',
			'is_scratch_readwrite',
			'is_sierra_fg-manager_reachable',
			'is_soft_read',
		);
		break;
	case "Inca":
		$tests = array(
			'amqp-test',
			'client-processes',
			'diskUsage',
			'leftoverFiles',
			'client-memusage',
			'server-user-filedescriptors',
			'server-memusage',
			'server-cleanLogs',
		);
		break;
	default:
		$tests = array();
	}
	return $tests;
}

function fg_phase_2_get_inca_test($test_suite, $resourceId, $ajax = '') {
	$xmlstr = file_get_contents("http://inca.futuregrid.org:8080/inca/XML/rest/$test_suite/$resourceId");
	$reports = simplexml_load_string($xmlstr);
	//$reports = json_decode(json_encode($xml)); the json_encode and json_decode were not handling all cases properly, easier to use xml

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

function fg_phase_2_get_ganglia_graph($metric, $report_type, $cluster, $period) {
	$img_url = "http://ganglia.futuregrid.org/graph.php?g=" . 
		$report_type . 
		"&z=small&c=" . $cluster . 
		"&m=" . $metric . 
		"&r=" . $period; 
	$output = "<img src='$img_url' />";
	return $output;
		
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
		'fg_inca_status_Basic' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Basic'
		),
		'fg_inca_status_Services' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Services'
		),
		'fg_inca_status_Grid' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Grid'
		),
		'fg_inca_status_HPC_Tests' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_HPC_Tests'
		),
		'fg_inca_status_Benchmarks' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Benchmarks'
		),
		'fg_inca_status_Modules' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Modules'
		),
		'fg_inca_status_Inca' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Inca'
		),
		'fg_inca_status_Storage' => array(
			'arguments' => array('tests' => array(), 'series' => array()),
			'template' => 'templates/fg_inca_status_Storage'
		),
	);
}
