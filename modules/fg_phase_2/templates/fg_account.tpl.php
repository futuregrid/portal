<div class="account-block profile-block">
	<h2><?php print $profile->title; ?></h2>
	<div class="block-content"><?php print $profile->content; ?></div>
</div>
<a href="#">Back to top</a>

<div class="account-block hpc-block">
	<h2><?php print $account_status->title; ?></h2>
	<div class="block-content"><?php print $account_status->content; ?></div>
</div>
<a href="#">Back to top</a>

<?php if ($links) : ?>
	<div class="account-block links-block">
		<h2><?php print $links->title; ?></h2>
		<div class="block-content"><?php print $links->content; ?></div>
	</div>
	<a href="#">Back to top</a>
<?php endif; ?>

<div class="account-block project-block">
	<h2>Project summary</h2>
	<div class="block-content">
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
</div>
<a href="#">Back to top</a>

<div class="account-block contents-block">
	<h2>Content summary</h2>
	<div class="block-content">
		<h3><?php print $manual_pages->title; ?></h3>
		<div>
			<?php print $manual_pages->content; ?>
		</div>
		
		<h3><?php print $community_pages->title; ?></h3>
		<div>
			<?php print $community_pages->content; ?>
		</div>
	</div>
</div>
<a href="#">Back to top</a>

<div class="account-block pubs-block">
	<h2><?php print $publications->title; ?></h2>
	<div class="block-content"><?php print $publications->content; ?></div>
</div>
<a href="#">Back to top</a>
