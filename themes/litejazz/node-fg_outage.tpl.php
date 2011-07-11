<div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
  <?php if ($picture) { print $picture; }?>

  <?php if ($page == 0) { ?>
    <?php if ($title) { ?>
      <h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
    <?php }; ?>
  <?php }; ?>

  <?php if ($submitted) { ?>
    <span class="submitted"><?php print $submitted?></span> 
  <?php }; ?>

  <?php if ($terms) { ?>
    <span class="taxonomy"><?php print $terms?></span>
  <?php }; ?>
	<div class="content">
		<h3><?php print t('FutureGrid Hardware Outage Information'); ?></h3>
		<p><?php print $node->title; ?></p>
		<dl>
			<dt><strong>Status</strong></dt>
			<dd><?php print $node->field_outage_status[0]['view']; ?></dd>
			<dt><strong>Type</strong></dt>
			<dd><?php print implode(', ', array_map(function($f){return $f['view'];}, $node->field_outage_type)); ?></dd>
			<dt><strong>Impacted systems</strong></dt>
			<dd><?php print implode(', ', array_map(function($f){return $f['view'];}, $node->field_outage_system)); ?></dd>
		</dl>
		<dl>
			<dt><strong>Start of outage</strong></dt>
			<dd><?php print $node->field_outage_start[0]['view']; ?></dd>
			<dt><strong>Anticipated end of outage</strong></dt>
			<dd>
				<?php
					if ($node->field_outage_end[0]['view']) {
						print $node->field_outage_end[0]['view'];
					} else {
						print t('Unknown');
					}
				?>
			</dd>
		</dl>
		<h4>Description</h4>
		<?php print _filter_autop($node->field_outage_description[0]['view']); ?>
		<?php if ($node->field_outage_resolution[0]['view']): ?>
			<h4>Resolution</h4>
			<?php print _filter_autop($node->field_outage_resolution[0]['view']); ?>
		<?php endif; ?>
	</div>
  <div class="clear-block clear"></div>

  <?php if ($links): ?>
    <div class="links">&raquo; <?php print $links; ?></div>
  <?php endif; ?>
</div>