<?php if ($tests) { ?>
	<dl class="inca-modules">
		<table>
			<th>Name</th>
			<th>Version</th>
			<th>Default</th>
			<th>Category</th>
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
						<td class='name'><?php print l($module['name'], $testUrl); ?></td>
						<td><?php print $module['version']; ?></td>
						<td><?php print $module['default']; ?></td>
						<td><?php print $module['category']; ?></td>
					</tr>
				<?php
				}
			?>
			</dd>
		<?php } else { ?>
			<dd>n/a</dd>
		<?php } ?>
		<?php endforeach; ?>
		</table>
	</dl>
<?php } else { ?>
	No tests available.
<?php } ?>
