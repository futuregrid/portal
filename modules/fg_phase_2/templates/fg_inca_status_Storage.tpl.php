<script type="text/javascript">
        $('.show_hide').click( function(e) {
                e.preventDefault();
                $(this).parent('i').next('p.error-message').toggle();
        });
</script>
<?php if ($tests) { ?>
	<dl class="inca-storage">
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
						if ($series[$name]->body->performance->benchmark) {
							foreach ($series[$name]->body->performance->attributes() as $key => $value) {
								print "<tr><td>" . $value . "</td>";
							}
							foreach ($series[$name]->body->performance->benchmark->attributes() as $key => $value) {
								print "<td>" . $value . "</td>";
							}
							foreach ($series[$name]->body->performance->benchmark as $benchmark) {
								foreach($benchmark->statistics->attributes() as $key => $value) {
									print "<td>" . $key . " : " . $value . "</td>";
								}
								print "</tr>";				
							}
						} else if ($series[$name]->body->unitTest->ID) {
							$testId = $series[$name]->body->unitTest->ID;
							print "<tr><td>" . $testId . "</td></tr>";

						}
						print "</table>";
					} else {
						print "<a target=\"_blank\" href=\"$testUrl\" class=\"test-error\">Error</a>";
						print "<i><a href=\"#\" class=\"show_hide\">(Show error)</a></i>";
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
