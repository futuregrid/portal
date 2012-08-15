<?php

function _fg_phase_2_ajax_callback($cluster, $node) {
	if ($cluster && $cluster != "null") {
		if ($node && $node != "null") {
			drupal_json(fg_phase_2_ganglia_metrics($cluster, $node));
		} else {
			drupal_json(fg_phase_2_ganglia_node_list($cluster));
		}
	} 
}

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

function _fg_phase_2_ganglia_pull_feed($url, $port, $filename) {
	$week_ago = strtotime('-1 day');

	if (!file_exists($filename) || filemtime($filename) < $week_ago) {
		$sock = fsockopen($url, $port);

		if ($sock) {
			$node_data = "";
			while (!feof($sock)) {
				$node_data .= fgets($sock, '1028');
			}

			file_put_contents($filename, $node_data);
			fclose($sock);
		} else {
			error_log("Could not open the socket.");
		}
	} 

	return simplexml_load_string(file_get_contents($filename));
}

function fg_phase_2_ganglia_metrics($cluster, $node) {

	$ganglia_nodes = _fg_phase_2_ganglia_pull_feed("ganglia.futuregrid.org", 8651, "/home/drupal/www/misc/ganglia.txt");
	$monitor_nodes = _fg_phase_2_ganglia_pull_feed("monitor.uc.futuregrid.org", 8651, "/home/drupal/www/misc/monitor.txt");

	if ($ganglia_nodes && $monitor_nodes) {
		$node_options = array();
		foreach ($ganglia_nodes->GRID->CLUSTER as $cluster_xml) {
			$cluster_attr = $cluster_xml->attributes();
			if ((string) $cluster_attr['NAME'] == $cluster) {
				foreach ($cluster_xml->HOST as $host) {
					$host_attr = $host->attributes();
					if ((string) $host_attr['NAME'] == $node) {
						foreach ($host->METRIC as $metric) {
							foreach ($metric->attributes() as $key => $value) {
								if ($key == "NAME") {
									$node_options[(string) $value] = (string) $value;
								}
							}
						}
					}
				}
			}
		}

		foreach ($monitor_nodes->GRID as $monitor_xml) {
			$grid_attr = $monitor_xml->attributes();
			if ((string) $grid_attr['NAME'] == $cluster) {
				foreach ($monitor_xml->CLUSTER->HOST as $host) {
					$host_attr = $host->attributes();
					if ((string) $host_attr['NAME'] == $node) {
						foreach ($host->METRIC as $metric) {
							foreach ($metric->attributes() as $key => $value) {
								if ($key == "NAME") {
									$node_options[(string) $value] = (string) $value;
								}
							}
						}
					}
				}
			}
		}
		return $node_options;
	} else {
		error_log("Could not pull the XML data for metrics.");
	}
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

function fg_phase_2_ganglia_graph_size() {
	return array(
		'small' => 'Small',
		'medium' => 'Medium',
		'large' => 'Large',
	);
}

function fg_phase_2_ganglia_node_list($cluster) {

	$ganglia_nodes = _fg_phase_2_ganglia_pull_feed("ganglia.futuregrid.org", 8651, "/home/drupal/www/misc/ganglia.txt");
	$monitor_nodes = _fg_phase_2_ganglia_pull_feed("monitor.uc.futuregrid.org", 8651, "/home/drupal/www/misc/monitor.txt");

	if ($ganglia_nodes && $monitor_nodes) {
		$node_options = array();
		foreach ($ganglia_nodes->GRID->CLUSTER as $cluster_xml) {
			$attributes = $cluster_xml->attributes();
			if ((string) $attributes['NAME'] == $cluster) {
				foreach ($cluster_xml->HOST as $host) {
					foreach ($host->attributes() as $key => $value) {
						if ($key == "NAME") {
							$node_options[(string) $value] = (string) $value;
						}
					}
				}
			}
		}

		foreach ($monitor_nodes->GRID as $grid_xml) {
			$attributes = $grid_xml->attributes();
			if ((string) $attributes['NAME'] == $cluster) {
				foreach ($grid_xml->CLUSTER->HOST as $host) {
					foreach ($host->attributes() as $key => $value) {
						if ($key == "NAME") {
							$node_options[(string) $value] = (string) $value;
						}
					}
				}
			}
		}
		return $node_options;
	} else {
		error_log("Could not pull XML data for the node list.");
	}
}

function fg_phase_2_ganglia_cluster_list() {

	$ganglia_nodes = _fg_phase_2_ganglia_pull_feed("ganglia.futuregrid.org", 8651, "/home/drupal/www/misc/ganglia.txt");
	$monitor_nodes = _fg_phase_2_ganglia_pull_feed("monitor.uc.futuregrid.org", 8651, "/home/drupal/www/misc/monitor.txt");

	if ($ganglia_nodes && $monitor_nodes) {
		$clusters = array();
		$clusters[""] = "Show option";
		foreach ($monitor_nodes->GRID as $grid) {
			foreach ($grid->attributes() as $key => $value) {
				if ($key == "NAME") {
					$clusters[(string) $value] = (string) $value;
				}
			}
		}

		foreach ($ganglia_nodes->GRID->CLUSTER as $cluster) {
			foreach ($cluster->attributes() as $key => $value) {
				if ($key == "NAME") {
					$clusters[(string) $value] = (string) $value;
				}
			}
		}

		return $clusters;
	} else {
		error_log("Could not pull XML data for the cluster list.");
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

function fg_phase_2_get_ganglia_graph($metric, $node, $report_type, $cluster, $period, $size) {
	if ($metric && $node) {
		$img_url = "http://ganglia.futuregrid.org/graph.php?" . 
			"&z=" . $size . 
			"&c=" . $cluster . 
			"&m=" . $metric . 
			"&h=" . $node .
			"&r=" . $period; 
	} else if ($report_type) {
		$img_url = "http://ganglia.futuregrid.org/graph.php?" . 
			"g=" . $report_type . 
			"&z=" . $size .
			"&c=" . $cluster .
			"&h=" . $node .  
			"&r=" . $period; 
	}
	error_log(print_r($img_url,1));
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
