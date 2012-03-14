<script type="text/javascript">
	$('#all_services').click( function(e) {
		e.preventDefault();
		$('.na').toggle();
	});
</script>

<?php if ($tests) { ?>
	<dl class="inca-services">
	<p><a href="#" id="all_services">Show all results</a></p>
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
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\">Error</a>";
						print "<p class=\"error-message\">".$series[$name]->errorMessage."</p>";
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
