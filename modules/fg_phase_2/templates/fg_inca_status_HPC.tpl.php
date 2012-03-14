<?php if ($tests) { ?>
	<dl class="inca-hpc">
	<?php foreach($tests as $name) : ?>
		<dt><?php echo $name; ?></dt>
		<dd>
			<?php
				if ($series[$name]) {
					$testUrl = 'http://inca.futuregrid.org:8080/inca/jsp/instance.jsp?';
					$testUrl .= 'nickname=' . $series[$name]->nickname;
					$testUrl .= '&resource=' . $series[$name]->hostname;
					$testUrl .= '&collected=' . $series[$name]->gmt;
					print "Version: " . l($series[$name]->body->package->version, $testUrl, array('attributes'=>array('target'=>'_blank')));
				} else {
					print "n/a";
				}
			?>
		</dd>
	<?php endforeach; ?>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
