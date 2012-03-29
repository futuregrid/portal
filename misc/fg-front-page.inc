<?php
$page = new stdClass;
$page->disabled = FALSE; /* Edit this to true to make a default page disabled initially */
$page->api_version = 1;
$page->name = 'front_page';
$page->task = 'page';
$page->admin_title = 'Front Page';
$page->admin_description = '';
$page->path = 'front-page';
$page->access = array();
$page->menu = array();
$page->arguments = array();
$page->conf = array();
$page->default_handlers = array();
$handler = new stdClass;
$handler->disabled = FALSE; /* Edit this to true to make a default handler disabled initially */
$handler->api_version = 1;
$handler->name = 'page_front_page_panel_context';
$handler->task = 'page';
$handler->subtask = 'front_page';
$handler->handler = 'panel_context';
$handler->weight = 0;
$handler->conf = array(
  'title' => 'Panel',
  'no_blocks' => 0,
  'pipeline' => 'standard',
  'css_id' => 'page-front',
  'css' => '',
  'contexts' => array(),
  'relationships' => array(),
);
$display = new panels_display;
$display->layout = 'frontpagelayout';
$display->layout_settings = array();
$display->panel_settings = array(
  'style_settings' => array(
    'default' => NULL,
    'center' => NULL,
    'accordion' => NULL,
    'news' => NULL,
    'projects' => NULL,
    'support' => NULL,
    'news_' => NULL,
    'projects_' => NULL,
    'support_' => NULL,
    'slider' => NULL,
    'accordion_' => NULL,
    'carousel' => NULL,
  ),
);
$display->cache = array();
$display->title = 'FutureGrid: a distributed testbed, exploring possibilities with Clouds, Grids, and High Performance Computing';
$display->content = array();
$display->panels = array();
  $pane = new stdClass;
  $pane->pid = 'new-1';
  $pane->panel = 'accordion';
  $pane->type = 'block';
  $pane->subtype = 'menu-menu-services';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'override_title' => 1,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-1'] = $pane;
  $display->panels['accordion'][0] = 'new-1';
  $pane = new stdClass;
  $pane->pid = 'new-2';
  $pane->panel = 'carousel';
  $pane->type = 'views';
  $pane->subtype = 'front_page_carousel';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'override_pager_settings' => 0,
    'use_pager' => 0,
    'nodes_per_page' => '10',
    'pager_id' => '',
    'offset' => '0',
    'more_link' => 0,
    'feed_icons' => 0,
    'panel_args' => 0,
    'link_to_view' => 0,
    'args' => '',
    'url' => '',
    'display' => 'default',
    'override_title' => 1,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-2'] = $pane;
  $display->panels['carousel'][0] = 'new-2';
  $pane = new stdClass;
  $pane->pid = 'new-3';
  $pane->panel = 'news';
  $pane->type = 'views';
  $pane->subtype = 'front_page_news';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'override_pager_settings' => 0,
    'use_pager' => 0,
    'nodes_per_page' => '5',
    'pager_id' => '',
    'offset' => '0',
    'more_link' => 0,
    'feed_icons' => 0,
    'panel_args' => 0,
    'link_to_view' => 0,
    'args' => '',
    'url' => '',
    'display' => 'default',
    'override_title' => 1,
    'override_title_text' => 'News',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-3'] = $pane;
  $display->panels['news'][0] = 'new-3';
  $pane = new stdClass;
  $pane->pid = 'new-4';
  $pane->panel = 'projects';
  $pane->type = 'custom';
  $pane->subtype = 'custom';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'admin_title' => '',
    'title' => 'Projects',
    'body' => '<?php
	global $user;
	$output = "<div>".t("It\'s easy to get started working on FutureGrid.  Project approval is fast. There are already more than 100 ongoing projects in diverse areas, and FutureGrid welcomes new proposals.")."</div>";
	$output .= l(t(\'Find a project to join\'), \'projects\', array(\'attributes\' => array(\'class\' => \'button\')));	
	
	if ($user->uid) {
		$output .= l(t(\'Create your own project\'), \'node/add/fg-projects\', array(\'attributes\' => array(\'class\' => \'button\')));
	} else {
		$output .= l(t(\'Apply for an account\'), \'user/register\', array(\'attributes\' => array(\'class\' => \'button\')));
	}
	
	echo $output;
?>',
    'format' => '3',
    'substitute' => TRUE,
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-4'] = $pane;
  $display->panels['projects'][0] = 'new-4';
  $pane = new stdClass;
  $pane->pid = 'new-5';
  $pane->panel = 'support';
  $pane->type = 'custom';
  $pane->subtype = 'custom';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'admin_title' => '',
    'title' => 'Support',
    'body' => '<?php
	$items = array(
		l(t(\'Getting started\'), \'node/1033\', array(\'attributes\' => array(\'class\' => \'button\'))),
		
		t(\'Consult the !manual\', array(\'!manual\' => l(t(\'FutureGrid Manual\'),\'node/104\'))),
		
		t(\'Work through the !tutorials\', array(\'!tutorials\' => l(t(\'Tutorials\'), \'node/48\'))),
		
		t(\'Having problems? FutureGrid expert support is here to help. !link\' , array(\'!link\' => l(t(\'Submit a ticket.\'),\'help\'))),

		t(\'Check out the !status.\', array(\'!status\' => l(t(\'current cloud status and stats\'),\'status\'))),
	);
	
	echo theme(\'item_list\', $items);
?>',
    'format' => '3',
    'substitute' => TRUE,
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-5'] = $pane;
  $display->panels['support'][0] = 'new-5';
$display->hide_title = PANELS_TITLE_FIXED;
$display->title_pane = '0';
$handler->conf['display'] = $display;
$page->default_handlers[$handler->name] = $handler;
