<?php if ($tests) { ?>
	<dl class="inca-benchmarks">
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
						print "<table class=\"statistics\">";
						if (is_array($series[$name]->body->performance->benchmark->statistics)) {
							foreach($series[$name]->body->performance->benchmark->statistics as $statistic) { 
								foreach($statistic as $stat_key => $stat_value) {
							?>
								<tr>
									<td><?php print $stat_key; ?></td>
									<td><?php print $stat_value; ?></td>
								</tr>
							<?php
								}
							}
						
						} else if (is_object($series[$name]->body->performance->benchmark->statistics)) {
							foreach ($series[$name]->body->performance->benchmark->statistics->attributes() as $stat_key => $stat_value) {
							?>
								<tr>
									<td><?php print $stat_key; ?></td>
									<td><?php print $stat_value; ?></td>
								</tr>
							<?php
							}
						}
						print "</table>";
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\"><img src=\"http://inca.futuregrid.org:8080/inca/img/fail.png\" /></a>";
						print "<p class=\"error-message\">".$series[$name]->errorMessage."</p>";
					}
				?>
			</dd>
		<?php } else { ?>
			<dt class="na"><?php echo $name; ?></dt>
			<dd class="na">n/a</dd>
		<?php } ?>
	<?php endforeach; ?>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
