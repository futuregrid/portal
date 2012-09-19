<script type="text/javascript">
	$(document).ready( function() {
		if ($('.na').length == 0) {
			$('#show-na').hide();
		}
		$('#show-na').bind('click', function(e) {
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
	<dl class="inca-hpc">
	<?php foreach($tests as $name) : ?>
			<?php
				if ($series[$name]) {
			?>
			<dt><?php echo $name; ?></dt>
			<dd>
			<?php
					$testUrl = 'http://inca.futuregrid.org:8080/inca/jsp/instance.jsp?';
					$testUrl .= 'nickname=' . $series[$name]->nickname;
					$testUrl .= '&resource=' . $series[$name]->hostname;
					$testUrl .= '&collected=' . $series[$name]->gmt;
					print "Version: " . l($series[$name]->body->package->version, $testUrl, array('attributes'=>array('target'=>'_blank')));
				} else {
				?>
				<dt class="na"><?php echo $name; ?></dt>
				<dd class="na">
				<?php
					print "n/a";
				}
			?>
		</dd>
	<?php endforeach; ?>
	<a href="#" id="show-na">Show N/A Results</a> 
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
