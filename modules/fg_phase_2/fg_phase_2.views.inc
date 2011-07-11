<?php
// $Id$

function fg_phase_2_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'fg_phase_2') . '/includes',
			),
    'handlers' => array(
      'fg_phase_2_views_handler_argument_role_name' => array(
        'parent' => 'views_handler_argument',
				),
      'fg_phase_2_views_handler_field_role_name' => array(
        'parent' => 'views_handler_field',
				),
    	),
		);
}

function fg_phase_2_views_data_alter(&$data) {
	$data['role']['table']['group'] = t('Role');
				
	$data['role']['rid'] = array(
		'title' => t('The role id'),
		'help' => t('The role id'),
		'field' => array(
      'handler' => 'views_handler_field_numeric',
      'click sortable' => TRUE,
			),
		'sort' => array(
			 'handler' => 'views_handler_sort',
			),
		);
	
	$data['role']['name'] = array(
		'title' => t('The role name'),
		'help' => t('The role name'),
		'field' => array(
			'handler' => 'fg_phase_2_views_handler_field_role_name',
			'click sortable' => TRUE,
			),
    'argument' => array(
      'handler' => 'fg_phase_2_views_handler_argument_role_name',
    ),
		'sort' => array(
			 'handler' => 'views_handler_sort',
			),
		);
}