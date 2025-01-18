<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Lang;
	use App\Models\Repositories\ReservationRepository;


	//(note to myself) generate today's date anf fill th container with divs for each hour of the day from 8 am to 5 pm
	$date=date("Y-m-d");

	$teacherDisponibilities = ReservationRepository::getTeacherDisponibilitiesByDate($date);

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
		$today = new DateTime();
		$today->setTime($startHour, 0);
		$endTime = new DateTime();
		$endTime->setTime($endHour, 0);

		$timeslots = [];

		while ($today < $endTime) {
			$slotStart = $today->format("H:i");
			$today->modify("+{$intervalMinutes} minutes");
			$slotEnd = $today->format("H:i");

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
	$todayTimeslots = generateTodayTimeslots(8, 17, 60);
	$date = (new DateTime())->format('Y-m-d');

	?>

<div class="tile disponibility_timeslots_tile" id="disponibility_timeslots_tile">
<h1><?= Lang::translate(key: "DISPONIBILITY_TIMESLOTS_TITLE") ?></h1>
<p><?= htmlspecialchars($date) ?></p>
<div id="timeslots_container">
	<?php
		$startHour = 8;
		$endHour = 17;

		for ($hour = $startHour; $hour < $endHour; $hour++) {
			$timeSlot = sprintf("%02d:00 - %02d:00", $hour, $hour + 1);
			$isReserved = isReserved($teacherDisponibilities, $hour);
	?>
			<div class="timeslot">
				<h2><?= htmlspecialchars($timeSlot) ?></h2>
				<?php if ($isReserved) { ?>
					<p><?= Lang::translate(key: "RESERVED") ?></p>
				<?php } else { ?>
					<p><?= Lang::translate(key: "AVAILABLE") ?></p>
				<?php } ?>
			</div>
	<?php
		}
	?>
</div>
</div>
