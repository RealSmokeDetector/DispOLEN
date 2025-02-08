<?php
	use App\Configs\Role;
	use App\Configs\State;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<h1 class="reservation_details_title"><?= Lang::translate(key: "RESERVATIONS_DETAILS_TITLE") ?></h1>

<div class="tile reservation_details_container" id="reservation_details_container">
	<input type="hidden" name="uid" value="<?= $reservationInfo["uid"] ?>">

	<h2 class="name"><?= Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT]) ? ApplicationData::nameFormat(name: $infoTeacher["name"], surname: $infoTeacher["surname"], complete: false, toChange: 1, reverse: true) : mb_strtoupper(string: htmlspecialchars(string: $infoStudent["surname"])) . " " . ucfirst(string: htmlspecialchars(string: $infoStudent["name"])) ?></h2>

	<p class="date" id="date_title"><?= $startDate->convertTime() . " - " . $endDate->convertTime() . " " . $endDate->convertDate() ?></p>

	<div class="line"></div>

	<div class="goal">
		<p class="reason"><i class="ri-slideshow-line"></i></p>
		<p id="reason_title"><?= ApplicationData::reasonFormat(id: $reservationInfo["id_reason"]) ?></p>

		<p class="type"><i class="ri-map-pin-line"></i></p>
		<p id="type_title"> <?= ApplicationData::typeFormat(id: $reservationInfo["id_type"]) ?></p>
	</div>

	<div class="state">
		<p><i class="ri-speed-up-line"></i></p>
		<p id="state_title" data-state="<?= $reservationInfo["id_state"] ?>"><?= ApplicationData::stateFormat(id: $reservationInfo["id_state"]) ?></p>
	</div>

	<h2 class="comment"><?= Lang::translate(key: "MAIN_COMMENT") ?></h2>
	<?php if ($reservationInfo["comment"]) { ?>
		<p id="comment_value">"<?= htmlspecialchars(string: $reservationInfo["comment"]) ?>"</p>
	<?php } else { ?>
		<p id="no_comment_title"><?= Lang::translate(key: "MAIN_NONE") . "." ?></p>
		<p id="comment_value"></p>
	<?php } ?>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) { ?>
		<select id="reason_edit" name="reason" style="display: none">
			<?php foreach ($reasons as $reason) { ?>
				<option value="<?= $reason ?>"
				<?= $reservationInfo["id_reason"] == $reason ? "selected" : "" ?>>
				<?= ApplicationData::reasonFormat(id: $reason) ?>
				</option>
			<?php } ?>
		</select>

		<select id="type_edit" name="type" style="display: none">
			<?php foreach ($types as $type) { ?>
				<option value="<?= $type ?>"
					<?= $reservationInfo["id_type"] == $type ? "selected" : "" ?>>
					<?= ApplicationData::typeFormat(id: $type) ?>
				</option>
			<?php } ?>
		</select>
	<?php } ?>

	<button type="button" class="button" id="submit_button" style="display : none"><?= Lang::translate(key: "MAIN_SUBMIT") ?></button>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) { ?>
		<div class="button_container">
			<button class="button" id="state" data-state="<?= State::ACCEPTED ?>" style="display: <?= $reservationInfo["id_state"] == 1 ? "block" : "none" ?>"><?= Lang::translate(key: "RESERVATIONS_DETAILS_ACCEPT") ?></button>

			<button class="button" id="state" data-state="<?= State::REFUSED ?>" style="display: <?= $reservationInfo["id_state"] == 1 ? "block" : "none" ?>"><?= Lang::translate(key: "RESERVATIONS_DETAILS_REFUSE") ?></button>

			<button class="button" id="edit_button" style="display: <?= $reservationInfo["id_state"] == 2 ? "block" : "none" ?>"><?= Lang::translate(key: "RESERVATIONS_DETAILS_UPDATE") ?></button>

			<button class="button" id="state" data-state="<?= State::CANCELED ?>" style="display: <?= $reservationInfo["id_state"] == 2 ? "block" : "none" ?>"><?= Lang::translate(key: "RESERVATIONS_DETAILS_CANCEL") ?></button>
		<?php } ?>
	</div>
</div>
