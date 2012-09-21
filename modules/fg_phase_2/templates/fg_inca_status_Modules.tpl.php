<script type="text/javascript">
	$(document).ready( function() {
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
	<dl class="inca-modules">
		<table>
			<th>Module</th>
			<th>Default</th>
			<th>Category</th>
			<col span="1" class='other'>
			<col span="1" class='default'>
			<col span="1" class='other'>	
		<?php foreach ($tests as $name) : ?>
		<?php if ($series[$name]) { ?>
			<dd class="module">
			<?php
				$testUrl = 'http://inca.futuregrid.org:8080/inca/jsp/instance.jsp?';
				$testUrl .= 'nickname=' . $series[$name]->nickname;
				$testUrl .= '&resource=' . $series[$name]->hostname;
				$testUrl .= '&collected=' . $series[$name]->gmt;
				foreach ($series[$name]->body->modules->module as $module) {
				?>
					<tr>
						<td><?php print l($module['name'] . " " . $module['version'], $testUrl); ?></td>
						<td><?php print $module['default']; ?></td>
						<td><?php print $module['category']; ?></td>
					</tr>
				<?php
				}
			?>
			</dd>
		<?php } else { ?>
			<dd class="na">n/a</dd>
		<?php } ?>
		<?php endforeach; ?>
		</table>
	<a href="#" class="show-na">Show N/A Results</a>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
