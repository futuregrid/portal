<p>
	A new publication has been submitted. 
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
	<strong>Project number(s)</strong>:
	<?php print $project; ?>
	<br>
	<strong>Keywords</strong>:
	<?php print $project_keywords; ?>
	<br>
	<strong>Publication URL</strong>:
	<?php print $publication_url; ?>
	<br><br>
	<strong>Data</strong>:
	<br>
	<?php print $publication_data; ?>
	<br><br>
	<?php if ($publication_attachment): ?>
	<p>
		<strong>Publication</strong>:
		<?php print $publication_attachment; ?>
	</p>
	<?php endif; ?>
</p>
