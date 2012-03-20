<?php
/**
 * @file maintenance-page.tpl.php
 *
 * Theme implementation to display a single Drupal page while off-line.
 *
 * All the available variables are mirrored in page.tpl.php. Some may be left
 * blank but they are provided for consistency.
 *
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<body class="<?php print $classes; ?>">

  <div id="page-wrapper"><div id="page">

    <div id="header"><div class="section clearfix">

      <?php if ($logo): ?>
        <a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
      <?php endif; ?>

      <?php if ($site_name || $site_slogan): ?>
        <div id="name-and-slogan">
          <?php if ($site_name): ?>
            <div id="site-name"><strong>
              <a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>" rel="home">
              <?php print $site_name; ?>
              </a>
            </strong></div>
          <?php endif; ?>
          <?php if ($site_slogan): ?>
            <div id="site-slogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>
        </div><!-- /#name-and-slogan -->
      <?php endif; ?>

      <?php print $header; ?>

    </div></div><!-- /.section, /#header -->

    <div id="main-wrapper"><div id="main" class="clearfix<?php if ($navigation) { print ' with-navigation'; } ?>">

      <div id="content" class="column"><div class="section">

        <?php print $highlight; ?>

        <?php if ($title): ?>
          <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php if ($messages): print $messages; endif; ?>

        <?php print $content_top; ?>

        <div id="content-area">
          <?php print $content; ?>
        </div>

        <?php print $content_bottom; ?>

      </div></div><!-- /.section, /#content -->

      <?php if ($navigation): ?>
        <div id="navigation"><div class="section clearfix">

          <?php print $navigation; ?>

        </div></div><!-- /.section, /#navigation -->
      <?php endif; ?>

      <?php print $sidebar_first; ?>

      <?php print $sidebar_second; ?>

    </div></div><!-- /#main, /#main-wrapper -->
 
		<div id="footer">
			<div class="section">
				<div id="footer-message">
					<span>The FutureGrid project is funded by the National Science Foundation (NSF) and is led by&nbsp;</span><a href="http://www.iub.edu/" target="_blank" title="Indiana University - Bloomington">Indiana University</a><span>&nbsp;with&nbsp;</span><a href="http://www.uchicago.edu/index.shtml" target="_blank" title="University of Chicago">University</a><a href="http://www.uchicago.edu/index.shtml" target="_blank" title="University of Chicago">&nbsp;of Chicago</a><span>,&nbsp;</span><a href="http://www.ufl.edu/" target="_blank" title="University of Florida">University of Florida</a><span>,&nbsp;</span><a href="http://www.sdsc.edu/" target="_blank" title="San Diego Supercomputing Center">San Diego Supercomputing Center</a><span>,&nbsp;</span><a href="http://www.tacc.utexas.edu/" target="_blank" title="Texas Advanced Computing Center">Texas Advanced Computing Center</a><span>,&nbsp;</span><a href="http://www.virginia.edu/">University of Virginia</a><span>,&nbsp;</span><a href="http://www.utk.edu/" target="_blank" title="University of Tennessee">University of Tennessee</a><span>,&nbsp;</span><a href="http://www3.isi.edu/home" target="_blank" title="University of California - Information Sciences Institute">University of Southern California</a><span>,&nbsp;</span><a href="http://w3.tue.nl/nl/" target="_blank" title=" Technische Universiteit Eindhoven">Dresden</a><span>,&nbsp;</span><a href="http://www.purdue.edu/" target="_blank" title="Purdue University">Purdue University</a><span>, and&nbsp;</span><a href="https://www.grid5000.fr/mediawiki/index.php/Grid5000:Home" target="_blank" title="Grid'5000">Grid 5000</a><span>&nbsp;as partner sites. This material is based upon work supported in part by the National Science Foundation under Grant No. 0910812.<br>
					<img alt="" src="/sites/default/files/u254/nsf-logo.png"></span>
				</div>
			</div>
		</div>

  </div></div><!-- /#page, /#page-wrapper -->

  <?php print $page_closure; ?>

  <?php print $closure; ?>

</body>
</html>
