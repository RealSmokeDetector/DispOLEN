<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Roles;
?>

<div class="blur" id="reservation_popup" style="display: none">
	<div class="tile reservation_add_popup">
		<i class="ri-close-circle-line close_popup" id="close_popup"></i>
		<div class="item" id="reservation_element">
			<?php
				require Path::COMPONENTS . "/actions/calendar.php";
				require Path::COMPONENTS . "/tiles/timeslots_tile.php";
			?>
			<?php if (Roles::check(userRoles: UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), allowRoles: [Role::TEACHER])) { ?>
			<div id="reservation_time" style="display: none">
				<input type="time" id="start_time" required>
				<input type="time" id="end_time" required>
				<input type="hidden" id="uid_user" value="<?= $_SESSION["user"]["uid"] ?>">
				<button id="add_availability" > Valider </button>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
