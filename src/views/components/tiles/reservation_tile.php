<?php
	use App\Utils\ApplicationData;
?>

<a id="user_tile" href="/reservation/details?reservation=<?= $reservationInfo["uid"] ?>" <?= ($iteration >= 10)?"class=\"hidden\"": ""?>>
	<div class="tile reservation_tile">
		<h2 class="name"><?= $name ?></h2>
		<p class="date"><?= $startDate->convertTime() . " - " . $endDate->convertTime() . " | " . $endDate->convertDate() ?></p>
		<p class="state"><i class="ri-speed-up-line"></i> <?= ApplicationData::stateFormat(id: $reservationInfo["id_state"]) ?></p>
	</div>
</a>
