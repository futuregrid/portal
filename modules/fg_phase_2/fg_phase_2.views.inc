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
			'fg_phase_2_views_handler_field_active_project' => array(
				'parent' => 'views_handler_field',
			),
			'fg_phase_2_views_handler_filter_active_project' => array(
				'parent' => 'views_handler_filter_boolean_operator',
			),
		),
	);
}

function fg_phase_2_views_data() {
	$data['content_type_fg_projects']['table']['group'] = t('FG Projects');
	$data['content_type_fg_projects']['table']['base'] = array(
		'field' => 'nid', 
		'title' => t('FG Project content'), 
		'help' => t("FG Project table."), 
		'weight' => -10,
	);
	
	$data['content_type_fg_projects']['table']['join'] = array(
		'node' => array(
			'left_field' => 'nid', 
			'field' => 'nid',
		),
	);
	
	$data['content_type_fg_projects']['nid'] = array(
		'title' => t('FG Project node'), 
		'help' => t('The node object for a project.'), 
		'relationship' => array(
			'base' => 'node', 
			'field' => 'nid', 
			'handler' => 'views_handler_relationship', 
			'label' => t('FG Project node'),
		),
	);
	
	$data['content_type_fg_projects']['field_project_lead_uid'] = array(
		'title' => t('FG Project Lead'), 
		'help' => t('The Lead for a project.'), 
		'relationship' => array(
			'base' => 'users', 
			'field' => 'uid', 
			'handler' => 'views_handler_relationship', 
			'label' => t('FG Project Lead'),
		),
	);
	
	$data['content_type_fg_projects']['field_project_manager_uid'] = array(
		'title' => t('FG Project Manager'), 
		'help' => t('The Manager for a project.'), 
		'relationship' => array(
			'base' => 'users', 
			'field' => 'uid', 
			'handler' => 'views_handler_relationship', 
			'label' => t('FG Project Manager'),
		),
	);
	
	$data['content_type_fg_projects']['project_lead_or_manager'] = array(
		'group' => t('FG Projects'),
		'title' => t('FG Project Lead or Manager'),
		'help' => t('The user who is a project lead or manager on an active project.'),
		'relationship' => array(
			'join_handler' => 'fg_phase_2_views_join_or',
			'label' => t('FG Project Lead/Manager'),
			'base' => 'content_type_fg_projects',
			'base field' => array(
				'field_project_lead_uid',
				'field_project_manager_uid',
			),
			'relationship field' => 'uid',
		),
	);
	
	$data['content_type_fg_projects']['active_project'] = array(
		'real field' => 'field_project_complete_date_value',
		'field' => array(
			'title' => t('Active project'),
			'help' => t('The project is active.'), 
 			'handler' => 'fg_phase_2_views_handler_field_active_project',
			'click sortable' => TRUE,
		),
		'filter' => array(
			'handler' => 'fg_phase_2_views_handler_filter_active_project',
			'title' => t('Active projects only'),
			'label' => t('Show Active projects only'),
			'help' => t('Filter to only active projects.'), 
			'type' => 'yes-no',
		),
	);
	
	return $data;
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
	
// 	$data['users']['content_type_fg_projects_lead_manager'] = array(
// 		'group' => t('FG Projects'),
// 		'title' => t('FG Project Lead or Manager'),
// 		'help' => t('The user who is a project lead or manager on an active project.'),
// 		'relationship' => array(
// 			'join_handler' => 'fg_phase_2_views_join_or',
// 			'label' => t('FG Project Lead/Manager'),
// 			'base' => 'content_type_fg_projects',
// 			'base field' => array(
// 				'field_project_lead_uid',
// 				'field_project_manager_uid',
// 			),
// 			'relationship field' => 'uid',
// // 			'extra' => array(
// // 				array(
// // 					'field'    => 'field_project_status_value',
// // 					'value'    => 'approved',
// // 					'operator' => '=',
// // 				),
// // 			),
// 		),
// 	);
	
}

class fg_phase_2_views_join_or extends views_join {

  /**
   * Build the SQL for the join this object represents.
   */
  function join($table, &$query) {
    if (empty($this->definition['table formula'])) {
      $right_table = "{" . $this->table . "}";
    }
    else {
      $right_table = $this->definition['table formula'];
    }
		
		//drupal_set_message('<pre>'.print_r($this,1).'</pre>');
		$ors = array();
		foreach ($this->field as $field) {
			if ($this->left_table) {
				$left = $query->get_table_info($this->left_table);
				$left_field = "$left[alias].$this->left_field";
			} else {
				$left_field = $this->left_field;
			}
			$ors[] = "$left_field = $table[alias].$field";
		}
    $output = " $this->type JOIN $right_table $table[alias] ON (" . implode(" OR ", $ors) . ")";
    // Tack on the extra.
    if (isset($this->extra)) {
      if (is_array($this->extra)) {
        $extras = array();
        foreach ($this->extra as $info) {
          $extra = '';
          // Figure out the table name. Remember, only use aliases provided
          // if at all possible.
          $join_table = '';
          if (!array_key_exists('table', $info)) {
            $join_table = $table['alias'] . '.';
          }
          elseif (isset($info['table'])) {
            $join_table = $info['table'] . '.';
          }

          // And now deal with the value and the operator.  Set $q to
          // a single-quote for non-numeric values and the
          // empty-string for numeric values, then wrap all values in $q.
          $raw_value = $this->db_safe($info['value']);
          $q = (empty($info['numeric']) ? "'" : '');

          if (is_array($raw_value)) {
            $operator = !empty($info['operator']) ? $info['operator'] : 'IN';
            // Transform from IN() notation to = notation if just one value.
            if (count($raw_value) == 1) {
              $value = $q . array_shift($raw_value) . $q;
              $operator = $operator == 'NOT IN' ? '!=' : '=';
            }
            else {
              $value = "($q" . implode("$q, $q", $raw_value) . "$q)";
            }
          }
          else {
            $operator = !empty($info['operator']) ? $info['operator'] : '=';
            $value = "$q$raw_value$q";
          }
          $extras[] = "$join_table$info[field] $operator $value";
        }

        if ($extras) {
          if (count($extras) == 1) {
            $output .= ' AND ' . array_shift($extras);
          }
          else {
            $output .= ' AND (' . implode(' ' . $this->extra_type . ' ', $extras) . ')';
          }
        }
      }
      else if ($this->extra && is_string($this->extra)) {
        $output .= " AND ($this->extra)";
      }
    }
    return $output;
  }

}