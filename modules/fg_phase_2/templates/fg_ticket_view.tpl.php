<dl class="ticket-status">
	<dt>Subject</dt>
	<dd><?php print check_plain($ticket['Subject']); ?></dd>
	
	<dt>Status</dt>
	<dd><?php print check_plain($ticket['Status']); ?></dd>
	
	<dt>Created by</dt>
	<dd><?php print check_plain($ticket['Creator']); ?></dd>
	
	<dt>Created</dt>
	<dd><?php print check_plain($ticket['Created']); ?></dd>
	
	<?php if ($ticket['Status'] == 'resolved') { ?>
		<dt>Resolved</dt>
		<dd><?php print check_plain($ticket['Resolved']); ?></dd>
	<?php } else { ?>
		<dt>Last updated</dt>
		<dd><?php print check_plain($ticket['LastUpdated']); ?></dd>
	<?php } ?>
</dl>

<h4>History</h4>
<div class="ticket-history-wrapper">
	<?php print $history_table; ?>
</div>