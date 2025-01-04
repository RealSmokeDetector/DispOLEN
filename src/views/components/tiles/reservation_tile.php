<?php
	use App\Models\Repositories\ReservationRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<div>
	<p><?= $name ?></p>
	<p><?= Lang::translate(key: "MAIN_DATE") ?> : <?= ReservationRepository::getStartDate(disponibilityUid: $reservation["uid_disponibilities"]) ?></p>
	<p><?= Lang::translate(key: "RESERVATION_STATE") ?> : <?= ApplicationData::getStateName(id: $reservation["id_state"]) ?></p>
</div>
