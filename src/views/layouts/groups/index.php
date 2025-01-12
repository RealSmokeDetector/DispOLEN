<?php
	use App\Configs\Path;
	use App\Utils\Lang;
?>

<div class="groups_container">
	<?php
		if (count(value: $groups) > 0) {
			foreach ($groups as $group) {
				include Path::COMPONENTS . "/tiles/group_control.php";
			}
	?>

	<div class="groups_content">

	<?php
			include Path::COMPONENTS . "/tiles/group_tile.php";

			foreach ($groups as $group) {
				include Path::COMPONENTS . "/tiles/group_student_tile.php";
			}
		} else {
	?>
		<div class="tile">
			<p><?= Lang::translate(key: "GROUPS_NO_GROUP") ?></p>
		</div>
	<?php } ?>

	</div>
</div>
