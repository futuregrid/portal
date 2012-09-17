<?php if ($tests) { ?>
	<dl class="inca-hpc-tests">
	<?php foreach($tests as $name) : ?>
		<?php if ($series[$name]) { ?>
			<dt><?php echo $name; ?></dt>
			<?php
				$success = $series[$name]->comparisonResult == 'Success';
				if ($success) {
					$warning = FALSE;
					if (is_array($series[$name]->body->performance->benchmark->statistics->statistic)) {
						foreach ($series[$name]->body->performance->benchmark->statistics->statistic as $statistic) {
							if ($statistic->ID == 'warnings') {
								$warning = $statistic->value > 0;
							}
						}
					}
				}
			?>
			<dd class="<?php $success ? $warning ? print 'success has-warning' : 'success' : 'error' ?>">
				<?php
					$testUrl = 'http://inca.futuregrid.org:8080/inca/jsp/instance.jsp?';
					$testUrl .= 'nickname=' . $series[$name]->nickname;
					$testUrl .= '&resource=' . $series[$name]->hostname;
					$testUrl .= '&collected=' . $series[$name]->gmt;
					if ($success) {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-success\"><img src=\"http://inca.futuregrid.org:8080/inca/img/pass.png\" /></a>";
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\"><img src=\"http://inca.futuregrid.org:8080/inca/img/fail.png\" /></a>";
					}
				?>
			</dd>
		<?php } else { ?>
			<dt class="na"><?php echo $name; ?></dt>
			<dd>n/a</dd>
		<?php } ?>
	<?php endforeach; ?>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
