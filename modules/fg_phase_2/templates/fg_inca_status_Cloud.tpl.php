<script type="text/javascript">
	$(document).ready( function() {
		if ($('.na').length == 0) {
			$('#show-na').hide();
		}
		$('#show-na').live('click', function(e) {
			var showNa = $(this);
			e.preventDefault();
			$('.na').each(function() {
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
	<dl class="inca-cloud">
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
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\"><img src=\"http://inca.futuregrid.org:8080/inca/img/error.png\" /></a>";

					}
				?>
			</dd>
		<?php } else { ?>
			<dt class="na"><?php echo $name; ?></dt>
			<dd class="na">n/a</dd>
		<?php } ?>
	<?php endforeach; ?>
	<a href="#" id="show-na">Show N/A Results</a>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
