<?php
	use App\Configs\Role;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<h1 class="reservation_details_title"><?= Lang::translate(key: "RESERVATIONS_DETAILS_TITLE") ?></h1>

<div class="tile reservation_details_container">
	<form id="formReservation" method="POST">
		<input type="hidden" name="uid" value="<?= $reservationData["uid"] ?>">

		<h2 class="name"><?= Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT]) ? ApplicationData::nameFormat(name: $infoTeacher["name"], surname: $infoTeacher["surname"], complete: false, toChange: 1, reverse: true) : mb_strtoupper(string: htmlspecialchars(string: $infoStudent["surname"])) . " " . ucfirst(string: htmlspecialchars(string: $infoStudent["name"])) ?></h2>

		<p class="date"><?= $date_start->convertTime() . " - " . $date_end->convertTime() . " " . $date_end->convertDate() ?></p>

		<div class="goal">
			<p class="reason" id="reason"><i class="ri-slideshow-line"></i> <?= ApplicationData::reasonFormat(id: $reservationData["id_reason"]) ?></p>

			<p class="type" id="type"><i class="ri-map-pin-line"></i> <?= ApplicationData::typeFormat(id: $reservationData["id_type"]) ?></p>
		</div>

		<p class="state" id="state" value="<?= $reservationData["id_state"] ?>" ><i class="ri-speed-up-line"></i> <?= ApplicationData::stateFormat(id: $reservationData["id_state"]) ?></p>

		<h2 class="comment"><?= Lang::translate(key: "MAIN_COMMENT") ?></h2>
		<?php if ($reservationData["comment"]) { ?>
			<p id="comment">"<?= htmlspecialchars(string: $reservationData["comment"]) ?>"</p>
		<?php } else { ?>
			<p id="no_comment"><?= Lang::translate(key: "MAIN_NONE") . "." ?></p>
			<p id="comment"></p>
		<?php } ?>

		<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) { ?>
			<select id="reasonSelect" name="reason" style="display: none">
				<?php foreach ($reasons as $reason) { ?>
					<option value="<?= $reason ?>"
					<?= $reservationData["id_reason"] == $reason ? "selected" : "" ?>>
					<?= ApplicationData::reasonFormat(id: $reason) ?>
					</option>
				<?php } ?>
			</select>

			<select id="typeSelect" name="type" style="display: none">
				<?php foreach ($types as $type) { ?>
					<option value="<?= $type ?>"
						<?= $reservationData["id_type"] == $type ? "selected" : "" ?>>
						<?= ApplicationData::typeFormat(id: $type) ?>
					</option>
				<?php } ?>
			</select>
		<?php } ?>

	</form>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER]) & $reservationData["id_state"] == 1) { ?>
		<form method="post">
			<input type="hidden" name="uid" value="<?= $reservationData["uid"] ?>">
			<button class="button" type="submit" name="action" value="accept"><?= Lang::translate(key: "RESERVATIONS_DETAILS_ACCEPT") ?></button>
			<button class="button" type="submit" name="action" value="refuse"><?= Lang::translate(key: "RESERVATIONS_DETAILS_REFUSE") ?></button>
		</form>
	<?php } ?>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER]) & $reservationData["id_state"] == 2) { ?>
		<button class="button" id="buttonId"><?= Lang::translate(key: "RESERVATIONS_DETAILS_UPDATE") ?></button>
		<form method="post">
			<input type="hidden" name="uid" value="<?= $reservationData["uid"] ?>">
			<button class="button" type="submit" name="action" value="cancel"><?= Lang::translate(key: "RESERVATIONS_DETAILS_CANCEL") ?></button>
		</form>
	<?php } ?>

</div>
