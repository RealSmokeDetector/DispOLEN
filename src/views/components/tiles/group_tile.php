<div class="tile group_container">
	<?php foreach ($groups as $group) {
		$group["uid"] === $selectedGroup ? $class = "button" : $class = "button button_secondary";
	?>
		<button class="<?= $class ?>" data-group="<?= $group["uid"] ?>"><?= $group["name"] ?></button>
	<?php } ?>
</div>
