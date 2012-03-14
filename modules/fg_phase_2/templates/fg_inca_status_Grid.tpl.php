<?php if ($tests) { ?>
<script type="text/javascript">
	$('.show_hide').click( function(e) {
		e.preventDefault();
		$(this).parent('i').next('p.error-message').toggle();
	});

	$('#all_grid').click( function(e) {
		e.preventDefault();
		$('.na').toggle();
	});
</script>
	<dl class="inca-grid">
	<p><a href="#" id="all_grid">Show all results</a></p>
	<?php foreach($tests as $name) : ?>
		<dt><?php echo $name; ?></dt>
		<?php if ($series[$name]) { ?>
			<?php
				$success = $series[$name]->comparisonResult == 'Success';
			?>
			<dd class="<?php $success ? print 'success' : print 'error' ?>">
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
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\">Error</a> ";
						print "<i><a href=\"#\" class=\"show_hide\">(Show)</a></i>";
						print "<p class=\"error-message\">" . $series[$name]->errorMessage . "</p>";
					}
				?>
			</dd>
		<?php } else { ?>
			<dd class="na">n/a</dd>
		<?php } ?>
	<?php endforeach; ?>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
