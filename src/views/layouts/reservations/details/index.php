<?php
	use App\Models\Repositories\ReservationRepository;
	use App\Utils\Lang;
	use App\Utils\ApplicationData;
?>

<div class="reservations_details_container">
	<h1><?= Lang::translate(key: "RESERVATIONS_DETAILS_TITLE") ?></h1>
	<p><strong>Date:</strong></p><p><?= htmlspecialchars(string: ReservationRepository::getStartDate(disponibilityUid: $reservationData["uid_disponibilities"])); ?></p>
	<p><strong><?= Lang::translate(key: "RESERVATIONS_DETAILS_TUTOR") ?> :</strong></p><p><?= htmlspecialchars( string: $name )?></p>
	<p><strong><?= Lang::translate(key: "MAIN_STATE") ?> :</strong> <?= htmlspecialchars(ApplicationData::getStateName( $reservationData["id_state"])); ?></p>
	<p><strong><?= Lang::translate(key: "MAIN_REASON") ?> :</strong><?= htmlspecialchars(ApplicationData::getReasonName( $reservationData["id_reason"])); ?></p>
	<p><strong>Type:</strong><?= htmlspecialchars(ApplicationData::getTypeName($reservationData["id_type"])); ?></p>
	<p><strong><?= Lang::translate(key: "MAIN_COMMENT") ?> :</strong><?= htmlspecialchars(string: $reservationData["comment"] ?? ""); ?></p>
</div>
