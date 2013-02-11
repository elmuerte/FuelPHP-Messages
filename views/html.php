<?php
/**
 * FuelPHP Messages
 * "MIT License"
 * Copyright 2013 Michiel Hendriks <elmuerte@drunksnipers.com>
 */
?>
<div class="alert alert-<?php echo $type; ?>">
	<a class="close" data-dismiss="alert" href="#">&times;</a>
	<?php if (strlen($title) > 0): ?>
	<h4>
		<?php echo $title; ?>
	</h4>
	<?php endif ?>
	<p>
		<?php echo $message; ?>
	</p>
</div>
