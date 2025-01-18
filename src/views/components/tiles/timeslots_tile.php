<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Lang;
	use App\Models\Repositories\ReservationRepository;


	//(note to myself) generate today's date anf fill th container with divs for each hour of the day from 8 am to 5 pm
	$date=date("Y-m-d");

	$teacherDisponibilities = ReservationRepository::getTeacherDisponibilitiesByDate($date);

	// Fonction pour vérifier s'il y a une réservation pour une heure donnée
	function getReservationForTime($reservations, $time) {
		foreach ($reservations as $reservation) {
			if (strpos($reservation["date_start"], $time) !== false) {

				return $reservation;
			}
		}
		return null;
	}

	?>

	<div class="tile disponibility_timeslots_tile" id="disponibility_timeslots_tile">
	<h1><?= Lang::translate(key: "DISPONIBILITY_TIMESLOTS_TITLE") ?></h1>
	<p><?= htmlspecialchars($date) ?></p>
	<div id="timeslots_container">
		<?php
			$startHour = 8;
			$endHour = 17;

			for ($hour = $startHour; $hour <= $endHour; $hour++) {
				$time = sprintf("%02d:00:00", $hour);
				$reservation = getReservationForTime($teacherDisponibilities, $time);
		?>
				<div class="timeslot">
					<h2><?= htmlspecialchars($time) ?></h2>
					<?php if ($reservation) { ?>
						<p><?= htmlspecialchars($reservation["date_start"]) ?> -> <?= htmlspecialchars($reservation["date_end"]) ?></p>
					<?php } else { ?>
						<p><?= Lang::translate(key: "NO_RESERVATION") ?></p>
					<?php } ?>
				</div>
		<?php
			}
		?>
	</div>
	</div>
