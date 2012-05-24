<?php
class fg_phase_2_views_handler_filter_active_project extends views_handler_filter_boolean_operator {

  function query() {
    $this->ensure_my_table();	
	if ($this->value) {
		$this->query->add_where($this->options['group'], "isnull($this->table_alias.$this->real_field)");
	}
  }
}