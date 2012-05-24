<?php
class fg_phase_2_views_handler_field_active_project extends views_handler_field {

  function query() {
    $this->ensure_my_table();
    $this->query->add_field('', 'isnull('.$this->table_alias.'.'.$this->real_field.')', 'active_project');
    $this->field_alias = 'active_project';
  }

  function render($values) {
    return $values->{$this->field_alias} ? 'Active' : 'Completed';
  }
}