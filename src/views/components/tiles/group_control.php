<?php
	$group["uid"] === $selectedGroup ? $display = "flex" : $display = "none";
?>

<div class="tile group_control" id="group_control" data-uid="<?= $group["uid"] ?>" style="display: <?= $display ?>">
	<p class="group_name"><?= htmlspecialchars(string: $group["name"]) ?></p>

	<div class="action">
		<button class="button" id="group_edit"><i class="ri-edit-line"></i></button>
		<button class="button" id="group_delete"><i class="ri-delete-bin-line"></i></button>
	</div>
</div>
