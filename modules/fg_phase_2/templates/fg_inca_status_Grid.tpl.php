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
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\">Error</a> ";
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
