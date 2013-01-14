<div class="node<?php print " $classes"; ?><?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
  <?php if ($picture) { print $picture; }?>

  <?php if ($page == 0) { ?>
    <?php if ($title) { ?>
      <h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
    <?php }; ?>
  <?php }; ?>

  <?php if ($node->project_admin_view && $submitted) { ?>
    <span class="submitted"><?php print $submitted?></span> 
  <?php }; ?>
<!--
  <x?php if ($terms) { ?>
    <span class="taxonomy"><x?php print $terms?></span>
  <x?php }; ?>
-->
  <div class="content">
    <h3>Project Information</h3>
  	<dl>
	<!--
  		<dt>Project ID</dt>
  		<dd><?php //print $node->field_projectid[0]['view']; ?>&nbsp;</dd>
  		
  		<dt>Title</dt>
  		<dd><?php //print $node->title; ?>&nbsp;</dd>
  		<?php //if ($node->field_project_status[0]['view']) : ?>
				<dt>Project Status</dt>
				<dd><?php //print $node->field_project_status[0]['view']; ?>&nbsp;</dd>
			<?php //endif; ?>
			
  		<?php //if ($node->field_project_scope[0]['view']) : ?>
				<dt>Scope</dt>
				<dd><?php //print $node->field_project_scope[0]['view']; ?>&nbsp;</dd>
			<?php //endif; ?>
	
			<dt>Keywords</dt>
			<dd><?php //print $node->field_project_keywords[0]['view']; ?>&nbsp;</dd>
			
  	-->	
  		<dt>Discipline</dt>
  		<dd><?php print $node->field_project_primary_discipline[0]['view']; ?>&nbsp;</dd>
  		
  		<?php if ($node->field_project_sec_discipline[0]['view']) : ?>
				<dt>Subdiscipline</dt>
				<dd><?php print $node->field_project_sec_discipline[0]['view']; ?>&nbsp;</dd>
			<?php endif; ?>
  		
  		<dt>Orientation</dt>
  		<dd><?php print $node->field_project_orientation[0]['view']; ?>&nbsp;</dd>
		</dl>
		
		<strong>Abstract</strong>
		<p><?php print $node->field_project_abstract[0]['view']; ?></p>

		<strong>Intellectual Merit</strong>
		<p><?php print $node->field_project_merit[0]['view']; ?></p>
		
		<strong>Broader Impacts</strong>
		<p><?php print $node->field_broader_impact[0]['view']; ?></p>
	
		<?php if ($node->field_project_contrib_sw[0]['view']): ?>
			<strong>Software Contributions</strong>
			<p><?php print $node->field_project_contrib_sw[0]['view']; ?></p>
		<?php endif; ?>
		
		<?php if ($node->field_project_contrib_doc[0]['view']): ?>
			<strong>Documentation Contribution</strong>
			<p><?php print $node->field_project_contrib_doc[0]['view']; ?></p>
		<?php endif; ?>

		<?php if ($node->field_project_soft_sup[0]['view']) :?>
			<strong>Will you be able to provide support for the software you develop?</strong>
			<p><?php print $node->field_project_soft_sup[0]['view']; ?></p>
		<?php endif; ?>
		
  	<h3>Project Contact</h3>
  	<dl>
  		<dt>Project Lead</dt>
  		<dd><?php print theme('user_fullname', $node->field_project_lead[0]['uid'], 1, 1); ?>&nbsp;</dd>
  		
  		<dt>Project Manager</dt>
  		<dd><?php print theme('user_fullname', $node->field_project_manager[0]['uid'], 1, 1); ?>&nbsp;</dd>
  		
			<?php if ($node->field_project_members[0]['uid']) : ?>
				<dt>Project Members</dt>
				<dd>
					<?php
						$members = array();
						foreach ($node->field_project_members as $member) {
							$members[] = theme('user_fullname', $member['uid']);
						}
						print implode(', ', $members);
					?>
					&nbsp;
				</dd>
			<?php endif; ?>
  	</dl>

  	<h3>Resource Requirements</h3>
  	<dl>
  		<dt><?php print format_plural(count($node->field_project_hw), 'Hardware System', 'Hardware Systems'); ?></dt>
  		<dd>
  			<ul>
					<?php foreach ($node->field_project_hw as $hw): ?>
						<li><?php print $hw['view']; ?></li>
					<?php endforeach; ?>
  			</ul>
  			&nbsp;
  		</dd>
  		
  		<?php if ($node->field_project_serv_wish[0]['view']) : ?>
				<dt>Software</dt>
				<dd>
					<ul>
						<?php foreach ($node->field_project_serv_wish as $sw): ?>
							<li><?php print $sw['view']; ?></li>
						<?php endforeach; ?>
					</ul>
					&nbsp;
				</dd>
			<?php endif; ?>
			
  		<?php if ($node->field_project_provisioning_type[0]['view']) : ?>
				<dt>Provisioning Type</dt>
				<dd>
					<ul>
						<?php foreach ($node->field_project_provisioning_type as $pt): ?>
							<li><?php print $pt['view']; ?></li>
						<?php endforeach; ?>
					</ul>
					&nbsp;
				</dd>
			<?php endif; ?>
  		
  		<?php if ($node->field_project_services[0]['view']) : ?>
				<dt>Service Access</dt>
				<dd>
					<ul>
						<?php foreach ($node->field_project_services as $st): ?>
							<li><?php print $st['view']; ?></li>
						<?php endforeach; ?>
					</ul>
					&nbsp;
				</dd>
			<?php endif; ?>
  	</dl>

		<strong>Use of FutureGrid</strong>
		<p><?php print $node->field_project_use[0]['view']; ?></p>

		<strong>Scale of Use</strong>
		<p><?php print $node->field_project_scale[0]['view']; ?></p>
  	
  	<?php if ($field_project_slide_agree[0]['view']) : ?>
			<h3>Slide Collection Agreement</h3>
			<strong>Do you agree?</strong>
			<p><?php print $node->field_project_slide_agree[0]['view']; ?></p>
		<?php endif; ?>
		
		<?php
			if (
				$node->field_project_submit_time[0]['view'] ||
				$node->field_project_approve_date[0]['view'] ||
				$node->field_project_start_date[0]['view'] ||
				$node->field_project_complete_date[0]['view']
			):
		?>
		<h3>Project Timeline</h3>
		<dl>
			<?php if ($node->field_project_submit_time[0]['view']) : ?>
				<dt>Submitted</dt>
				<dd><?php print $node->field_project_submit_time[0]['view']; ?>&nbsp;</dd>
			<?php endif; ?>
			
			<?php if ($node->field_project_approve_date[0]['view']) : ?>
				<dt>Approved</dt>
				<dd><?php print $node->field_project_approve_date[0]['view']; ?>&nbsp;</dd>
			<?php endif; ?>
			
			<?php if ($node->field_project_start_date[0]['view']) : ?>
				<dt>Started</dt>
				<dd><?php print $node->field_project_start_date[0]['view']; ?>&nbsp;</dd>
			<?php endif; ?>
			
			<?php if ($node->field_project_complete_date[0]['view']) : ?>
				<dt>Completed</dt>
				<dd><?php print $node->field_project_complete_date[0]['view']; ?>&nbsp;</dd>
			<?php endif; ?>
		</dl>
		<?php endif; ?>
		
  </div>

	<div>
		<?php print comment_render($node); ?>
	</div>
  
  <div class="clear-block clear"></div>

  <?php if ($links): ?>
    <div class="links">&raquo; <?php print $links; ?></div>
  <?php endif; ?>

</div>
