<p>
	<?php print $summary; ?>
</p>

<p>
	<strong>Name</strong>:
	<?php print $user_first_name . ' ' . $user_last_name; ?>
	<br>
	<strong>Portal username</strong>:
	<?php print $user_portal_name; ?>
	<br>	
	<strong>Email</strong>:
	<?php print $user_email; ?>
	<br>
	<strong>Project number</strong>:
	<?php print $project; ?>
	<br>
	<strong>Category</strong>:
	<?php print implode(', ', $categories); ?>
	<br>
	<strong>Resources</strong>:
	<?php print implode(', ', $resources); ?>
</p>

<?php if ($attachment): ?>
<p>
	<strong>Attachment</strong>:
	<?php print $attachment; ?>
</p>
<?php endif; ?>
