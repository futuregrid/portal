<div class="panel-display frontpagelayout clear-block" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
	<div class="widget-row clear-block">
		<div class="panel-panel widget featured">
			<div class="inside"><?php print $content['carousel']; ?></div>
		</div>
		<div class="panel-panel widget accordion">
			<div class="inside"><?php print $content['accordion']; ?></div>
		</div>
	</div>
	<div class="widget-row clear-block">
		<div class="panel-panel widget news">
			<div class="inside"><?php print $content['news']; ?></div>
		</div>
		<div class="panel-panel widget projects">
			<div class="inside"><?php print $content['projects']; ?></div>
		</div>
		<div class="panel-panel widget support">
			<div class="inside"><?php print $content['support']; ?></div>
		</div>
	</div>
</div>
