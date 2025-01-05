<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Models\Repositories\ReservationRepository;
	use App\Models\Reservation;
?>

<div class="reservations_details_container">
	<h1><?= Lang::translate("RESERVATIONS_DETAILS_TITLE") ?></h1>
	<p><strong>Date:</strong></p><p><?= htmlspecialchars(ReservationRepository::getStartDate($reservationData["uid_disponibilities"])); ?></p>
	<p><strong><?= Lang::translate("RESERVATIONS_DETAILS_TUTOR") ?> :</strong></p><p><?= htmlspecialchars($reservationData["uid_teacher"]); ?></p>
	<p><strong><?= Lang::translate("MAIN_STATE") ?> :</strong> <?= htmlspecialchars($reservationData["id_state"]); ?></p>
	<p><strong><?= Lang::translate("MAIN_REASON") ?> :</strong><?= htmlspecialchars($reservationData["id_reason"]); ?></p>
	<p><strong>Type:</strong><?= htmlspecialchars($reservationData["id_type"]); ?></p>
	<p><strong><?= Lang::translate("MAIN_COMMENT") ?> :</strong><?= htmlspecialchars($reservationData["comment"]); ?></p>
</div>
