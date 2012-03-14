<?php if ($tests) { ?>
	<dl class="inca-basic">
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
						if (is_array($series[$name]->body->unitTest->ID)) {
							foreach ($series[$name]->body->unitTest->ID as $unitTest) {
							?>
								<tr>
									<td><?php print $unitTest; ?></td>
								</tr>
							<?php
							}
						} else if (is_object($series[$name]->body->unitTest->ID)) {
							$unitTest = $series[$name]->body->unitTest->ID;
							?>
								<tr>
									<td><?php print $unitTest; ?></td>
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
