<?php if ($tests) { ?>
	<dl class="inca-modules">
		<table>
		<?php foreach ($tests as $name) : ?>
		<?php if ($series[$name]) { ?>
			<dd class="module">
			<?php
				$testUrl = 'http://inca.futuregrid.org:8080/inca/jsp/instance.jsp?';
				$testUrl .= 'nickname=' . $series[$name]->nickname;
				$testUrl .= '&resource=' . $series[$name]->hostname;
				$testUrl .= '&collected=' . $series[$name]->gmt;
				foreach ($series[$name]->body->modules->module as $module) {
				?>
						<div width="10"><?php print l($module['name'], $testUrl); ?></div>
						<ul>
						<li><?php print "Version: " . $module['version']; ?></li>
						<li><?php print "Default: " . $module['default']; ?></li>
						<li><?php print "Category: " . $module['category']; ?></li>
						</ul>
				<?php
				}
			?>
			</dd>
		<?php } else { ?>
			<dd>n/a</dd>
		<?php } ?>
		<?php endforeach; ?>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
