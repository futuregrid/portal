<?php
// $Id$

// Declare all the .view files in the views subdir that end in .view
function fg_phase_2_views_default_views() {
  $files = file_scan_directory(drupal_get_path('module', 'fg_phase_2'). '/views', '.view');
  foreach ($files as $absolute => $file) {
    require $absolute;
    if (isset($view)) {
      $views[$file->name] = $view;
    }
  }
  return $views;
}

