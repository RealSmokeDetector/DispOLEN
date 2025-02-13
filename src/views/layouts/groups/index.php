<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<div class="groups_container">
	<?php
		if (count(value: $groups) > 0) {
			foreach ($groups as $group) {
				$group["uid"] === $selectedGroup ? $display = "flex" : $display = "none";

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

	<?php
		if (Roles::check(userRoles: $roles, allowRoles: [Role::ADMINISTRATOR])) {
			include Path::COMPONENTS . "/actions/add_button.php";
		}
	?>

</div>
