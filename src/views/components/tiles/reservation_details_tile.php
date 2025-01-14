<?php
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<a href="/reservation/details?reservation=<?= $reservation["uid"] ?>">
	<div class="tile reservation_tile">
		<h2 class="name"><?= $name ?></h2>
		<p class="date"><?= $date_start->convertTime() . " - " . $date_end->convertTime() . " " . $date_end->convertDate() ?></p>
		<p class="state"><i class="ri-speed-up-line"></i> <?= ApplicationData::getStateName(id: $reservation["id_state"]) ?></p>
	</div>
</a>
