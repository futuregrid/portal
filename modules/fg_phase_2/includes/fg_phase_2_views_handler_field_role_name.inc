<?php
class fg_phase_2_views_handler_field_role_name extends views_handler_field {
	
  function option_definition() {
    $options = parent::option_definition();

    $options['case'] = array('default' => 'ucfirst');

    return $options;
  }
  
  function case_transform($string) {
		global $multibyte;
    switch ($this->options['case']) {
      case 'upper':
        return drupal_strtoupper($string);
      case 'lower':
        return drupal_strtolower($string);
      case 'ucfirst':
        return drupal_strtoupper(drupal_substr($string, 0, 1)) . drupal_substr($string, 1);
      case 'ucwords':
        if ($multibyte == UNICODE_MULTIBYTE) {
          return mb_convert_case($string, MB_CASE_TITLE);
        } else {
          return ucwords($string);
        }
      default:
        return $string;
    }
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['case'] = array(
      '#type' => 'select',
      '#title' => t('Case'),
      '#description' => t('When printing the argument result, how to transform the case.'),
      '#options' => array(
        'none' => t('No transform'),
        'upper' => t('Upper case'),
        'lower' => t('Lower case'),
        'ucfirst' => t('Capitalize first letter'),
        'ucwords' => t('Capitalize each word'),
      ),
      '#default_value' => $this->options['case'],
    );
  }
  
  function render($values) {
    $value = $this->case_transform($values->{$this->field_alias});
    return check_plain($value);
  }

}