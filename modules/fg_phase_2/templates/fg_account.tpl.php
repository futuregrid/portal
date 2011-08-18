<h2><?php print $profile->title; ?></h2>
<div class="account-block profile-block">
	<?php print $profile->content; ?>
</div>

<h2><?php print $account_status->title; ?></h2>
<div class="account-block hpc-block">
	<?php print $account_status->content; ?>
</div>

<?php if ($links) : ?>
	<h2><?php print $links->title; ?></h2>
	<div class="account-block links-block">
		<?php print $links->content; ?>
	</div>
<?php endif; ?>

<h2>Project summary</h2>
<div class="account-block project-block">
	<h3><?php print $my_projects->title; ?></h3>
	<div>
		<?php print $my_projects->content; ?>
	</div>
	
	<h3><?php print $managed_projects->title; ?></h3>
	<div>
		<?php print $managed_projects->content; ?>
	</div>
	
	<h3><?php print $member_projects->title; ?></h3>
	<div>
		<?php print $member_projects->content; ?>
	</div>
	
	<h3><?php print $expert_projects->title; ?></h3>
	<div>
		<?php print $expert_projects->content; ?>
	</div>
</div>

<h2>Content summary</h2>
<div class="account-block contents-block">
	<h3><?php print $manual_pages->title; ?></h3>
	<div>
		<?php print $manual_pages->content; ?>
	</div>
	
	<h3><?php print $community_pages->title; ?></h3>
	<div>
		<?php print $community_pages->content; ?>
	</div>
</div>

<h2><?php print $publications->title; ?></h2>
<div class="account-block pubs-block">
	<?php print $publications->content; ?>
</div>
