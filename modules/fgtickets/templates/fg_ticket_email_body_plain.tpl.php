<?php 

	print $summary;
?>


Name:             <?php print $user_first_name . ' ' . $user_last_name; ?>

Portal username:  <?php print $user_portal_name; ?>
	
Email:            <?php print $user_email; ?>

Project number:   <?php print "FG-" . $project->field_projectid[0]['value']; ?>

Category:         <?php print implode(', ', $categories); ?>

Resources:        <?php print implode(', ', $resources); ?>


<?php if ($attachment): ?>

Attachment:
<?php print $attachment; ?>

<?php endif; ?>
