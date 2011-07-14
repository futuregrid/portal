<h2>FutureGrid Portal Ticket Submission</h2>

<h3>Submission info</h3>
<p>
	<strong>Name</strong>:
	<?php print $user_first_name . ' ' . $user_last_name; ?>
	<br>
	<strong>Portal username</strong>:
	<?php print $user_portal_name; ?>
	<br>	
	<strong>Email</strong>:
	<?php print $user_email; ?>
</p>

<h3>Subject</h3>
<p>
	<?php print $subject; ?>
</p>

<h3>Project</h3>
<p>
	<strong>Project number</strong>:
	<?php print $project->field_projectid[0]['value']; ?>
	<br>
	<strong>Project name</strong>:
	<?php print check_plain($project->title); ?>
</p>

<h3>Category</h3>
<p>
	<?php print implode(', ', $categories); ?>
</p>

<h3>Summary</h3>
<p>
	<?php print $summary; ?>
</p>

<?php if ($attachment): ?>
<p>
	<strong>Attachment</strong>:
	<?php print $attachment; ?>
</p>
<?php endif; ?>