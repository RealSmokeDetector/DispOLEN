<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Date;
	use App\Utils\Lang;
	use App\Utils\Roles;
	use App\Models\Repositories\ReservationRepository;

	//(note to myself) generate today's date anf fill th container with divs for each hour of the day from 8 am to 5 pm
	$date = new Date(date: "2025-06-25 08:00:00");
	define(constant_name: "HEIGHT_TIMESLOTS_DIV", value: 306);

	$teacherDisponibilities = ReservationRepository::getTeacherDisponibilitiesByDate(date: $date);

	// Function checking if there's a reservation for given time
	function getReservationForTime($reservations, $time) {
		foreach ($reservations as $reservation) {
			if (strpos($reservation["date_start"], needle: $time) !== false) {

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
			$today->adjusteTimeMin(minute: 30);
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
	<div id="timeslots_container" class="timeslots_container">
		<div class="times">
			<?php
				for ($hour = 8; $hour <= 19; $hour++) {
			?>
			<p class="time"><?= date("H:i", strtotime($date->hour.":".$date->minute)) ?></p>
			<?php
				$date->adjusteTimeMin(minute: 60);
			} ?>
		</div>
		<div class="availabilities_container">
			<?php
				for ($hour = 8; $hour <= 18; $hour++) {
					$isReserved = isReserved(reservations: $teacherDisponibilities, hour: $hour);
			?>
			<div class="availability" id="reservations"></div>
			<?php }
				foreach ($teacherDisponibilities as $timeslot) {
					$dateStart = new Date(date: $timeslot["date_start"]);
					$dateEnd = new Date(date: $timeslot["date_end"]);
			?>
					<div class="availability_reserved" style="position:fixed; height:<?=(($dateStart->getDurationDate(dateEnd: $dateEnd) / 60) * HEIGHT_TIMESLOTS_DIV) / (11 * 60) ?>px; transform: translateY(<?= (($dateStart->getDurationDateAvailableReservations() / 60) * HEIGHT_TIMESLOTS_DIV) / (11 * 60)?>px); width: 90px;" ></div>
			<?php } ?>
		</div>
	</div>
</div>
