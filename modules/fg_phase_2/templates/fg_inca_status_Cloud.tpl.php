<?php if ($tests) { ?>
	<?php foreach($tests as $name) : ?>
		<h1><?php echo $name; ?></h1>
		<pre>
			<?php print_r($series[$name]); ?>
		</pre>
	<?php endforeach; ?>
<?php } else { ?>
	No tests available.
<?php } ?>