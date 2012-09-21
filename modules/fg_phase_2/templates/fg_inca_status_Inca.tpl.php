<script type="text/javascript">
	$(document).ready( function() {
		if ($('.na').length == 0) {
			$('.show-na').hide();
		}
		$('.show-na').bind('click', function(e) {
			var showNa = $(this);
			e.preventDefault();
			showNa.prevAll('.na').each(function() {
				if ($(this).is(':visible')) {
					$(this).hide();
					showNa.html("Show N/A Results");
				} else {
					$(this).show();
					showNa.html("Hide N/A Results");
				}
			});
		});
	});
</script>

<?php if ($tests) { ?>
	<dl class="inca-inca">
	<?php foreach($tests as $name) : ?>
		<?php if ($series[$name]) { ?>
			<dt><?php echo $name; ?></dt>
			<?php
				$success = $series[$name]->comparisonResult == 'Success';
				if ($success || !$series[$name]->comparisonResult) {
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
					if ($success || !$series[$name]->comparisonResult) {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-success\"><img src=\"http://inca.futuregrid.org:8080/inca/img/pass.png\" /></a>";
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\"><img src=\"http://inca.futuregrid.org:8080/inca/img/error.png\" /> : </a>";
						print "<i>(" . $series[$name]->comparisonResult . ")</i>";
					}
					print "<table class=\"statistics\">";
					if (is_array($series[$name]->body->performance->benchmark->statistics->statistic)) {
						foreach ($series[$name]->body->performance->benchmark->statistics->statistic as $statistic) {
					?>
							<tr>
								<td><?php print $statistic->ID; ?></td>
								<td><?php print $statistic->value . $statistic->units; ?></td>
							</tr>
						<?php

						}
					} else if (is_object($series[$name]->body->performance->benchmark->statistics->statistic)) {
						foreach($series[$name]->body->performance->benchmark->statistics->statistic as $statistic) {
						?>
							<tr>
								<td><?php print $statistic->ID; ?></td>
								<td><?php print $statistic->value . $statistic->units; ?></td>
							</tr>
						<?php
						}
					}
					print "</table>";
				?>
			</dd>
		<?php } else { ?>
			<dt class="na"><?php echo $name; ?></dt>
			<dd class="na">n/a</dd>
		<?php } ?>
	<?php endforeach; ?>
	<a href="#" class="show-na">Show N/A Results</a>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
