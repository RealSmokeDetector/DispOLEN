<?php
	use App\Configs\Role;
	use App\Models\Repositories\ReservationRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<div class="reservations_details_container">
	<form id="formReservation" method="POST">
		<h1><?= Lang::translate(key: "RESERVATIONS_DETAILS_TITLE") ?></h1>

		<input type="hidden" name="uid" value="<?= $reservationData["uid"]?>">

		<p><strong>Date:</strong></p>
		<p><?= htmlspecialchars(string: ReservationRepository::getStartDate(disponibilityUid: $reservationData["uid_disponibilities"])); ?></p>

		<?php if (!empty(array_intersect($roles, [Role::STUDENT]))) { ?>

			<p><strong><?= Lang::translate(key: "RESERVATIONS_DETAILS_TUTOR") ?> :</strong></p>
			<p><?= htmlspecialchars(string: $reservationData["uid_teacher"]); ?></p>

		<?php } ?>

		<?php if (!empty(array_intersect($roles, [Role::TEACHER]))) { ?>

			<p><strong><?= Lang::translate(key: "RESERVATIONS_DETAILS_STUDENT") ?> :</strong></p>
			<p id="student"><?= ApplicationData::nameFormat(name: $infoStudent["name"], surname: $infoStudent["surname"], reverse: true) ?></p>

		<?php } ?>

		<p><strong><?= Lang::translate(key: "MAIN_STATE") ?> : </strong> </p>
		<p id="state"><?= htmlspecialchars(string: $reservationData["id_state"]); ?></p>
		<select id="stateSelect" name="state" style="display: none">
			<?php foreach ($states as $state) { ?>
				<option value="<?= $state ?>">
					<?= $state ?>
				</option>
			<?php } ?>
		</select>

		<p><strong><?= Lang::translate(key: "MAIN_REASON") ?> :</strong> </p>
		<p id="reason"><?= htmlspecialchars(string: $reservationData["id_reason"]); ?></p>
		<select id="reasonSelect" name="reason" style="display: none">
			<?php foreach ($reasons as $reason) { ?>
				<option value="<?= $reason ?>"><?= $reason ?></option>
			<?php } ?>
		</select>

		<p><strong>Type:</strong></p>
		<p id="type"><?= htmlspecialchars(string: $reservationData["id_type"]); ?></p>
		<select id="typeSelect" name="type" style="display: none">
			<?php foreach ($types as $type) { ?>
				<option value="<?= $type ?>"><?= $type ?></option>
			<?php } ?>
		</select>

		<p><strong><?= Lang::translate(key: "MAIN_COMMENT") ?> :</strong></p>
		<p id="comment"><?= htmlspecialchars(string: $reservationData["comment"] ?? ""); ?></p>
	</form>
	<button class="button" id="buttonId">Modifier</button>
</div>
