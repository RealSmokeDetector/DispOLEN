<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Date;
	use App\Utils\Lang;
	use App\Models\Repositories\ReservationRepository;

	//(note to myself) generate today's date anf fill th container with divs for each hour of the day from 8 am to 5 pm
	$date = new Date();

	$teacherDisponibilities = ReservationRepository::getTeacherDisponibilitiesByDate(date: $date);

	// Function checking if there's a reservation for given time
	function getReservationForTime($reservations, $time) {
		foreach ($reservations as $reservation) {
			if (strpos($reservation["date_start"], $time) !== false) {

				return $reservation;
			}
		}
		return null;
	}

	// function generating timesolts
	function generateTodayTimeslots($startHour, $endHour, $intervalMinutes) {
		$today = new Date();
		$timeslotsInterval = $today->GetIntervaleDay($startHour, $endHour);

		$timeslots = [];

		while ( $today < $timeslotsInterval["dateEnd"]) {
			$slotStart = $today->GetTime();
			$today->adjusteTimeSec(30);
			$slotEnd = $today->GetTime();

			$timeslots[] = [
				'start' => $slotStart,
				'end' => $slotEnd
			];
		}

		return $timeslots;
	}

	// check if reserved
	function isReserved($reservations, $hour) {
		foreach ($reservations as $reservation) {
			$startHour = (int)date("H", strtotime($reservation["date_start"]));
			$endHour = (int)date("H", strtotime($reservation["date_end"]));

			if ($hour >= $startHour && $hour < $endHour) {
				return true;
			}
		}
		return false;
	}
	// timeslots from 8 am t 5pm
	$todayTimeslots = generateTodayTimeslots(startHour: 8, endHour: 19, intervalMinutes: 30);

?>

<div class="tile disponibility_timeslots_tile" id="disponibility_timeslots_tile" data-uid="<?= $_SESSION["user"]["uid"]?>">
	<h1><?= Lang::translate(key: "DISPONIBILITY_TIMESLOTS_TITLE") ?></h1>
	<p id="timesolt_date"><?= htmlspecialchars($date->GetDate()) ?></p>
	<div class="line"></div>
	<div id="timeslots_container" class="timeslots">
		<?php
			$startHour = 8;
			$endHour = 19;

			for ($hour = $startHour; $hour <= $endHour; $hour++) {
				$timeSlot = sprintf( "%02d:00",  $hour);
				$isReserved = isReserved(reservations: $teacherDisponibilities, hour: $hour);
		?>
				<div class="time_container">
					<div class="timeslot">
						<p><?= htmlspecialchars($timeSlot) ?></p>
						<!-- <?= ($isReserved)? Lang::translate(key: "RESERVED") : Lang::translate(key: "AVAILABLE"); ?></p> -->
					</div>
					<div class="line<?= ($isReserved) ? " slot" : ""?>"></div>
				</div>
		<?php
			}
		?>
	</div>
</div>
