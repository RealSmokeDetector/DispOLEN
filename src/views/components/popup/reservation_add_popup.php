<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<div class="blur" id="reservation_popup" style="display: none">
	<div class="tile reservation_add_popup">
		<i class="ri-close-circle-line close_popup" id="close_popup"></i>
		<div class="item" id="reservation_element">
			<?php require Path::COMPONENTS . "/actions/calendar.php"; ?>
			<div class="tile">
				<?php require Path::COMPONENTS . "/tiles/timeslots_tile.php"; ?>
			</div>
			<?php if (Roles::check(userRoles: UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), allowRoles: [Role::TEACHER])) { ?>
				<div class="reservation_time" id="reservation_time">
					<div class="time">
						<input type="time" id="start_time" value="08:00" required>
						<input type="time" id="end_time" value="09:00" required>
					</div>
					<input type="hidden" id="uid_user" value="<?= $_SESSION["user"]["uid"] ?>">
					<button class="button" id="add_availability"><?= Lang::translate(key: "MAIN_ADD") ?></button>
				</div>
			<?php } ?>
			<?php if (Roles::check(userRoles: UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), allowRoles: [Role::STUDENT])) { ?>
				<div class="reservation_time" id="student_reservation_time" style="display: none">
					<div class="time">
						<?php
						$start = ($startDate->getHour() <= 9 ? '0' . $startDate->getHour() : $startDate->getHour()) . ":" .
						($startDate->getMinute() <= 9 ? '0' . $startDate->getMinute() : $startDate->getMinute());
						$end = ($endDate->getHour() <= 9 ? '0' . $endDate->getHour() : $endDate->getHour()) . ":" .
						($endDate->getMinute() <= 9 ? '0' . $endDate->getMinute() : $endDate->getMinute());
						?>
						<input type="time" id="selected_start_time" min="<?=$start?>" max="<? $end?>" value="<?= $start?>" required>
						<input type="time" id="selected_end_time" min="<? $start?>" max="<? $end?>" value="<?= $end ?>" required>
					</div>
					<input type="hidden" id="uid_user" value="<?= $_SESSION["user"]["uid"] ?>">
					<input type="hidden" id="uid_teacher" value="<?= $userRepo->getTutor() ?>">
					<button class="button" id="add_availability"><?= Lang::translate(key: "MAIN_ADD") ?></button>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
