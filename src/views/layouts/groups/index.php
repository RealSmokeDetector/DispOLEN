<?php
	use App\Configs\Path;
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
		}
	?>

	</div>
</div>
