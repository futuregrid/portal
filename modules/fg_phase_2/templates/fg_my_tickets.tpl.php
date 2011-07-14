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
	<div class="tickets-accordion">
		<?php foreach ($tickets as $id => $ticket) : ?>
			<h3>
				<?php print $ticket; ?>
				<?php print l($id, "products/get/$id", array('attributes'=>array('class'=>'ticket-id'))); ?>
			</h3>
			<div>
				<div class="ticket-summary"></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php } ?>
<p>
	<?php print l(t('Submit a ticket'), 'fg/tickets/submit'); ?>
</p>