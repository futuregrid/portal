<?php if ($tests) { ?>
	<dl class="inca-hpc-tests">
	<?php foreach($tests as $name) : ?>
		<dt><?php echo $name; ?></dt>
		<?php if ($series[$name]) { ?>
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
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-success\">Success</a>";
						print "<table class=\"statistics\">";
						if (is_array($series[$name]->body->performance->benchmark->statistics->statistic)) {
							foreach ($series[$name]->body->performance->benchmark->statistics->statistic as $statistic) {
							?>
								<tr>
									<td><?php print $statistic->ID; ?></td>
									<td><?php print $statistic->value.$statistic->units; ?></td>
								</tr>
							<?php
							}
						} else if (is_object($series[$name]->body->performance->benchmark->statistics->statistic)) {
							$statistic = $series[$name]->body->performance->benchmark->statistics->statistic;
							?>
								<tr>
									<td><?php print $statistic->ID; ?></td>
									<td><?php print $statistic->value.$statistic->units; ?></td>
								</tr>
							<?php
						}
						print "</table>";
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\">Error</a>";
						print "<p class=\"error-message\">".$series[$name]->errorMessage."</p>";
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
