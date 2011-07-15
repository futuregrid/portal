<?php if (empty($tickets)) { ?>
	<div>
		<h3><?php print t('No tickets to display.'); ?></h3>
		<p>
			Please note, there may be some delay before a ticket appears in this view.
			Recently submitted tickets may not display immediately.
		</p>
	</div>
<?php } else { ?>
	<p>
		Your tickets are listed below.  Click on a ticket title to expand the details for that ticket.
	</p>
	<p>
		Please note, there may be some delay before a ticket appears in this view.
		Recently submitted tickets may not display immediately.
	</p>
	<table id="my-tickets" class="fg-tickets">
		<thead>
			<tr>
				<th><?php print t('ID'); ?></th>
				<th><?php print t('Created'); ?></th>
				<th><?php print t('Subject'); ?></th>
				<th><?php print t('Status'); ?></th>
				<th><?php print t('Last updated'); ?></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<?php
		foreach ($tickets as $tid => $subj) {
			print l($tid, "fg/tickets/my/load-row-ajax/$tid", array('attributes' => array('class' => 'ticket-id')));
		}
	?>
	<div class="fg-loading"><?php print t('Loading tickets...'); ?></div>
<?php } ?>
<p>
	<?php print l(t('Submit a ticket'), 'fg/tickets/submit'); ?>
</p>