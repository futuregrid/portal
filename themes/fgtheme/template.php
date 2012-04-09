<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to fgtheme_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: fgtheme_breadcrumb()
 *
 *   where fgtheme is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function fgtheme_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  
  // Add your theme hooks like this:
	$hooks['user_register'] = array(
		'arguments' => array('form' => NULL),
		'template' => 'templates/user-register'
	);
	$hooks['user_fullname'] = array(
		'arguments' => array(
			'uid' => NULL,
			'link_to_user' => TRUE,
			'include_username' => FALSE
		),
	);
	$hooks['accordion_list'] = array(
		'arguments' => array(
			'items' => array(),
		),
	);
	
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
function fgtheme_preprocess(&$vars, $hook) {
	if (drupal_is_front_page()) {
		drupal_add_css(drupal_get_path('theme','fgtheme') . '/css/page-front.css');
		drupal_add_js(drupal_get_path('theme','fgtheme') . '/js/views-carousel.js');
	}
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function fgtheme_preprocess_page(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');

  // To remove a class from $classes_array, use array_diff().
  //$vars['classes_array'] = array_diff($vars['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function fgtheme_preprocess_node(&$vars, $hook) {
	$node = $vars['node'];
	
	if (drupal_is_front_page()) {
		$vars['template_files'][] = 'node-front';
		drupal_add_css(drupal_get_path('theme', 'fgtheme') . "/css/node-front.css");
		$function = __FUNCTION__ . '_front';
		$function($vars, $hook);
	}
	
	// Don't clobber Views 3 classes.
  if (!array_key_exists('classes', $vars)) {
  	$classes[] = drupal_html_class('node-type-' . $vars['type']);
    $vars['classes'] = implode(' ', $classes);
  }
  
  // add css per node type
  $nodetype_css_path = drupal_get_path('theme','fgtheme').'/css/node-'.$node->type.'.css';
  if (file_exists($nodetype_css_path)) {
  	drupal_add_css($nodetype_css_path, 'theme');
  }
  
  // add js per node type
  $nodetype_js_path = drupal_get_path('theme','fgtheme').'/js/node-'.$node->type.'.js';
  if (file_exists($nodetype_js_path)) {
  	drupal_add_js($nodetype_js_path, 'theme');
  }
  
  // Optionally, run node-type-specific preprocess functions, like
  // fgtheme_preprocess_node_page() or fgtheme_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}

function fgtheme_preprocess_node_front(&$vars, $hook) {
	$view = views_get_view('front_page_carousel');
	$vars['carousel'] = $view->execute_display('default');
	
	$vars['features'] = _fgtheme_features();
	
	$view = views_get_view('front_page_news');
	$vars['news'] = theme('box', t('News'), $view->execute_display('default'));
	
	$vars['projects'] = theme('box', t('Projects'), _fgtheme_getting_started());
	
	$vars['support'] = theme('box', t('Support'), _fgtheme_support());
}

function _fgtheme_features() {
	
	$items = array(
		array(
			'title' => 'Cloud Infrastructure',
			'children' => array(
				l(t('Nimbus'), 'node/157'),
				l(t('Eucalyptus'), 'node/156'),
				l(t('Openstack'), 'node/1305'),
			),
		),
		array(
			'title' => 'Cloud Platforms',
			'children' => array(
				l(t('Hadoop'), 'node/1314'),
				l(t('Twister'), 'node/1324'),
			),
		),
		array(
			'title' => 'Grid',
			'children'  => array(
				l(t('Unicore'),'node/682'),
				l(t('Genesis II'),'node/712'),
			),
		),
		array(
			'title' => 'HPC',
			'children'  => array(
				l(t('Torque/Moab'),'node/141'),
				l(t('MPI'),'node/681'),
				l(t('ScaleMP'),'node/1350'),
			),
		),
		array(
			'title' => 'Hardware',
			'children' => array(
				l(t('Clusters'),'node/139'),
				l(t('Storage'),'node/139'),
				l(t('Networking'),'node/1150'),
			),
		),
	);
	
	return theme('accordion_list', $items);
}

function _fgtheme_getting_started() {
	global $user;
	$output = "<div>".t("It's easy to get started working on FutureGrid.  Project approval is fast. There are already more than 100 ongoing projects in diverse areas, and FutureGrid welcomes new proposals.")."</div>";
	$output .= l(t('Find a project to join'), 'projects', array('attributes' => array('class' => 'button')));	
	
	if ($user->uid) {
		$output .= l(t('Create your own project'), 'node/add/fg-projects', array('attributes' => array('class' => 'button')));
	} else {
		$output .= l(t('Apply for an account'), 'user/register', array('attributes' => array('class' => 'button')));
	}
	
	return $output;
}

function _fgtheme_support() {
	$items = array(
		l(t('Getting started'), 'node/1033', array('attributes' => array('class' => 'button'))),
		
		t('Consult the !manual', array('!manual' => l(t('FutureGrid Manual'),'node/104'))),
		
		t('Work through the !tutorials', array('!tutorials' => l(t('Tutorials'), 'node/48'))),
		
		t('Having problems? FutureGrid expert support is here to help. !link' , array('!link' => l(t('Submit a ticket.'),'help'))),

		t('Check out the !status.', array('!status' => l(t('current cloud status and stats'),'status'))),
	);
	
	return theme('item_list', $items);
}

function fgtheme_preprocess_node_fg_projects(&$vars, $hook) {
	$node = $vars['node'];
	if ($node->project_admin_view) {
		$vars['template_files'][] = 'node-fg_projects-admin_view';
	}
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function fgtheme_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function fgtheme_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

function fgtheme_preprocess_user_register(&$vars) {
	$orig = $vars['form']['account']['mail']['#description'];
	$new = t('Please use your e-mail from your university or organization. Please avoid using gmail, hotmail or other non organizational e-mails, as they may lead to a delay or in some cases to a rejection of the account request.');
	$new .= ' ';
	$new .= t('All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.');
	$vars['form']['account']['mail']['#description'] = $new;
}

function fgtheme_user_fullname($object, $link_to_user = TRUE, $include_username = FALSE) {
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

function fgtheme_accordion_list($items, $include_js = TRUE) {

	if ($include_js && module_exists('jquery_ui')) {
		jquery_ui_add('ui.accordion');
		drupal_add_js(drupal_get_path('theme', 'fgtheme').'/js/accordion-list.js');
	}
	
	$output = '<div class="accordion-list">';
	
	foreach ($items as $item) {
		$output .= '<h3>'.$item['title'].'</h3>'.theme('item_list', $item['children']);
	}
	
	$output .= '</div>';
	return $output;
}

function fgtheme_preprocess_frontpagelayout(&$vars) {
	if (module_exists('jquery_ui')) {
		jquery_ui_add('ui.accordion');
		drupal_add_js($vars['layout']['path'] . '/frontpagelayout.js');
	}
}

function fgtheme_preprocess_block(&$vars) {
	global $user;
	$block = &$vars['block'];
	if ($block->module == 'menu' && $block->delta == 'menu-user' && $block->region == 'session') {
		if ($user->uid) {
			$vars['content'] = $block->content = str_replace('<a href="/user" title="">My Account</a>', t('Welcome, !user!', array('!user' => l($user->name,'user'))), $block->content);
		} else {
			$vars['content'] = $block->content = str_replace('<a href="/user" title="">My Account</a>', l(t('Log in'),'user/login'), $block->content);
		}
	}
}