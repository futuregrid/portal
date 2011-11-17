<?php
// $Id: template.php,v 1.4.2.1 2008/09/09 11:16:40 roopletheme Exp $

function phptemplate_body_class($sidebar_left, $sidebar_right) {
  if ($sidebar_left != '' && $sidebar_right != '') {
    $class = 'sidebars';
  }
  else {
    if ($sidebar_left != '') {
      $class = 'sidebar-left';
    }
    if ($sidebar_right != '') {
      $class = 'sidebar-right';
    }
  }
 
  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

if (is_null(theme_get_setting('litejazz_style'))) {
  global $theme_key;
  // Save default theme settings
  $defaults = array(
    'litejazz_style' => 0,
    'litejazz_width' => 0,
    'litejazz_fixedwidth' => '850',
    'litejazz_breadcrumb' => 0,
    'litejazz_iepngfix' => 0,
    'litejazz_themelogo' => 0,
    'litejazz_fontfamily' => 0,
    'litejazz_customfont' => '',
    'litejazz_uselocalcontent' => 0,
    'litejazz_localcontentfile' => '',
    'litejazz_leftsidebarwidth' => '210',
    'litejazz_rightsidebarwidth' => '210',
    'litejazz_suckerfish' => 0,
    'litejazz_usecustomlogosize' => 0,
    'litejazz_logowidth' => '100',
    'litejazz_logoheight' => '100',
  );

  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge(theme_get_settings($theme_key), $defaults)
  );
  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);
}

function get_litejazz_style() {
  $style = theme_get_setting('litejazz_style');
  if (!$style) {
    $style = 'blue';
  }
  if (isset($_COOKIE["litejazzstyle"])) {
    $style = $_COOKIE["litejazzstyle"];
  }
  return $style;
}

$style = get_litejazz_style();
drupal_add_css(drupal_get_path('theme', 'litejazz') .'/css/'. $style .'.css', 'theme');

if (theme_get_setting('litejazz_iepngfix')) {
   drupal_add_js(drupal_get_path('theme', 'litejazz') .'/js/jquery.pngFix.js', 'theme');
}

if (theme_get_setting('litejazz_themelogo'))
{
   function _phptemplate_variables($hook, $variables = array()) {
     $variables['logo'] = base_path() . path_to_theme() . '/images/' . theme_get_setting('litejazz_style') . '/logo.png';

     return $variables;
   }
}

if (theme_get_setting('litejazz_suckerfish')) {
   drupal_add_css(drupal_get_path('theme', 'litejazz') .'/css/suckerfish_'. $style .'.css', 'theme');
}

if (theme_get_setting('litejazz_uselocalcontent')) {
  $local_content = drupal_get_path('theme', 'litejazz') .'/'. theme_get_setting('litejazz_localcontentfile');
  if (file_exists($local_content)) {
    drupal_add_css($local_content, 'theme');
  }
}

function phptemplate_menu_links($links, $attributes = array()) {

  if (!count($links)) {
    return '';
  }
  $level_tmp = explode('-', key($links));
  $level = $level_tmp[0];
  $output = "<ul class=\"links-$level ". $attributes['class'] ."\" id=\"". $attributes['id'] ."\">\n";

  $num_links = count($links);
  $i = 1;

  foreach ($links as $index => $link) {
    $output .= '<li';

    $output .= ' class="';
    if (stristr($index, 'active')) {
      $output .= 'active';
    }
    elseif ((drupal_is_front_page()) && ($link['href']=='<front>')) {
      $link['attributes']['class'] = 'active';
      $output .= 'active';
    }
    if ($i == 1) {
      $output .= ' first'; }
    if ($i == $num_links) {
      $output .= ' last'; }
    $output .= '"';
    $output .= ">". l($link['title'], $link['href'], $link['attributes'], $link['query'], $link['fragment']) ."</li>\n";
    $i++;
  }
  $output .= '</ul>';
  return $output;
}

/********************************************************************************
 * Below functions added for FG.
 ********************************************************************************/

function litejazz_theme() {
	return array(
		'user_register' => array(
    	'arguments' => array('form' => NULL),
    	'template' => 'user-register'
		),
		'user_fullname' => array(
			'arguments' => array(
				'uid' => NULL,
				'link_to_user' => TRUE,
				'include_username' => FALSE
			),
		),
	);
}

function litejazz_preprocess(&$vars) {
	drupal_add_js(drupal_get_path('theme', 'litejazz') . '/js/fg.js');
}

function litejazz_preprocess_node(&$vars) {
	$node = $vars['node'];
	drupal_add_css(drupal_get_path('theme', 'litejazz') . "/node-$node->type.css");
	
	// Don't clobber Views 3 classes.
  if (!array_key_exists('classes', $vars)) {
  	$classes[] = drupal_html_class('node-type-' . $vars['type']);
    $vars['classes'] = implode(' ', $classes);
  }
  
  if ($node->type == 'fg_projects' && $node->project_admin_view) {
  	$vars['template_files'][] = 'node-fg_projects-admin_view';
  }
}

function litejazz_preprocess_user_register(&$vars) {
	$orig = $vars['form']['account']['mail']['#description'];
	$new = t('Please use your e-mail from your university or organization. Please avoid using gmail, hotmail or other non organizational e-mails, as they may lead to a delay or in some cases to a rejection of the account request.');
	$new .= ' ';
	$new .= t('All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.');
	$vars['form']['account']['mail']['#description'] = $new;
}

function litejazz_user_fullname($object, $link_to_user = TRUE, $include_username = FALSE) {
	global $user;
	
	if (is_object($object) && $object->uid) {
		$account = $object;
	} else {
		$account = user_load($object);
	}
	
	if ($account) {
		profile_load_profile($account);
		
		$fullname = $account->profile_firstname . " " . $account->profile_lastname;
		if ($include_username) {
			$fullname .= ' (' . $account->name . ')';
		}
		
		if ($link_to_user && ($user->uid == $account->uid || user_access('access user profiles'))) {
			$output = l($fullname, "user/$account->uid");
		} else {
			$output = check_plain($fullname);
		}
	}
	return $output;
}

if (!function_exists('drupal_html_class')) {
  /**
   * Prepare a string for use as a valid class name.
   *
   * Do not pass one string containing multiple classes as they will be
   * incorrectly concatenated with dashes, i.e. "one two" will become "one-two".
   *
   * @param $class
   *   The class name to clean.
   * @return
   *   The cleaned class name.
   */
  function drupal_html_class($class) {
    // By default, we filter using Drupal's coding standards.
    $class = strtr(drupal_strtolower($class), array(' ' => '-', '_' => '-', '/' => '-', '[' => '-', ']' => ''));

    // http://www.w3.org/TR/CSS21/syndata.html#characters shows the syntax for valid
    // CSS identifiers (including element names, classes, and IDs in selectors.)
    //
    // Valid characters in a CSS identifier are:
    // - the hyphen (U+002D)
    // - a-z (U+0030 - U+0039)
    // - A-Z (U+0041 - U+005A)
    // - the underscore (U+005F)
    // - 0-9 (U+0061 - U+007A)
    // - ISO 10646 characters U+00A1 and higher
    // We strip out any character not in the above list.
    $class = preg_replace('/[^\x{002D}\x{0030}-\x{0039}\x{0041}-\x{005A}\x{005F}\x{0061}-\x{007A}\x{00A1}-\x{FFFF}]/u', '', $class);

    return $class;
  }
} /* End of drupal_html_class conditional definition. */
