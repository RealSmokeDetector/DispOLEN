<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<div class="index_container">
	<?php
		if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER, Role::STUDENT])) {
			require Path::COMPONENTS . "/tiles/reservations_list_tile.php";
		}
	?>
	<?php require Path::COMPONENTS . "/actions/calendar.php"; ?>

	<div class="tile timeslots_tile" id="timeslots_tile" data-uid="<?= $_SESSION["user"]["uid"] ?>">
		<h1 class="title"><?= Lang::translate(key: "TIMESLOTS_TITLE") ?></h1>
		<p class="title" id="timesolt_date"><?= $dateRepo->convertDate() ?></p>

		<div class="line"></div>

		<?php require Path::COMPONENTS . "/tiles/timeslots_tile.php"; ?>
	</div>
</div>
