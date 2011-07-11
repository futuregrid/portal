<?php
class fg_phase_2_views_handler_argument_role_name extends views_handler_argument {
  function option_definition() {
    $options = parent::option_definition();

    $options['break_phrase'] = array('default' => TRUE);

    return $options;
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);

    // allow + for or, , for and
    $form['break_phrase'] = array(
      '#type' => 'checkbox',
      '#title' => t('Allow multiple terms per argument.'),
      '#description' => t('If selected, users can enter multiple arguments in the form of 1+2+3 or 1,2,3.'),
      '#default_value' => !empty($this->options['break_phrase']),
    );
  }

  function title() {
    if (!$this->argument) {
      return !empty($this->definition['empty field name']) ? $this->definition['empty field name'] : t('Uncategorized');
    }

    if (!empty($this->options['break_phrase'])) {
      $this->_break_phrase($this->argument);
    }
    else {
      $this->value = array($this->argument);
      $this->operator = 'or';
    }

    if (empty($this->value)) {
      return !empty($this->definition['empty field name']) ? $this->definition['empty field name'] : t('Uncategorized');
    }

    if ($this->value === array(-1)) {
      return !empty($this->definition['invalid input']) ? $this->definition['invalid input'] : t('Invalid input');
    }

    return implode($this->operator == 'or' ? ' + ' : ', ', $this->title_query());
  }

  /**
   * Override for specific title lookups.
   */
  function title_query() {
    return $this->value;
  }

  function query() {
    $this->ensure_my_table();

    if (!empty($this->options['break_phrase'])) {
      $this->_break_phrase($this->argument);
    }
    else {
      $this->value = array($this->argument);
    }

    if (count($this->value) > 1) {
      $operator = empty($this->options['not']) ? 'IN' : 'NOT IN';
      $placeholders = implode(', ', array_fill(0, sizeof($this->value), '\'%s\''));
      $this->query->add_where(0, "$this->table_alias.$this->real_field $operator ($placeholders)", $this->value);
    }
    else {
      $operator = empty($this->options['not']) ? '=' : '!=';
      $this->query->add_where(0, "$this->table_alias.$this->real_field $operator '%s'", $this->argument);
    }
  }
  
  function _break_phrase($str) {
		if (preg_match('/^([a-zA-Z0-9 _\-]+[+])+[a-zA-Z0-9 _\-]+$/', $str)) {
			// The '+' character in a query string may be parsed as ' '.
			$this->operator = 'or';
			$this->value = preg_split('/[+]/', $str);
		}
		else if (preg_match('/^([a-zA-Z0-9 _\-]+,)*[a-zA-Z0-9 _\-]+$/', $str)) {
			$this->operator = 'and';
			$this->value = explode(',', $str);
		}
  }
}

