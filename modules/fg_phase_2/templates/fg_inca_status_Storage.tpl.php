<script type="text/javascript">
	$(document).ready( function() {
		$('.show-na').bind('click', function(e) {
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
	<dl class="inca-storage">
	<?php foreach($tests as $name) : ?>
		<?php if ($series[$name]) { ?>
			<dt><?php echo $name; ?></dt>
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
	<a href="#" class="show-na">Show N/A Results</a>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
