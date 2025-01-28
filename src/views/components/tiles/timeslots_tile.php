<?php
	use App\Models\Entities\Reservation;
	use App\Models\Entities\User;
	use App\Utils\Date;
	use App\Utils\Lang;
	use App\Models\Repositories\ReservationRepository;

	$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $_SESSION["user"]["uid"])));
	$teacherDisponibilities = $reservationRepo->getDisponibilities(date: $date);
?>

<div class="tile disponibility_timeslots_tile" id="disponibility_timeslots_tile" data-uid="<?= $_SESSION["user"]["uid"]?>">
	<h1><?= Lang::translate(key: "DISPONIBILITY_TIMESLOTS_TITLE") ?></h1>
	<p id="timesolt_date"><?= $date->GetDate() ?></p>

	<div class="line"></div>
	<div class="timeslots_container">
		<div class="times">
			<?php for ($hour = 8; $hour <= 19; $hour++) { ?>

			<p class="time"><?= date(format: "H:i", timestamp: strtotime(datetime: $date->hour . ":" . $date->minute)) ?></p>

			<?php
					$date->adjusteTimeMin(minute: 60);
				}
			?>
		</div>

		<div class="availabilities_container" id="availabilities_container">
			<?php
				for ($hour = 8; $hour <= 18; $hour++) {
					// $isReserved = ReservationRepository::isReserved(reservations: $teacherReservation, hour: $hour);
			?>
					<div class="availability" id="reservations" data-day="<?= $date->GetDate() ?>" data-hour="<?= $hour ?>"></div>
			<?php }
				foreach ($teacherDisponibilities as $timeslot) {
					$dateStart = new Date(date: $timeslot["date_start"]);
					$dateEnd = new Date(date: $timeslot["date_end"]);

					$height = (($dateStart->getDurationDate(dateEnd: $dateEnd) / 60) * HEIGHT_TIMESLOTS_DIV) / (11 * 60);
					$translate = (($dateStart->getIntervalFromBegin() / 60) * HEIGHT_TIMESLOTS_DIV) / (11 * 60);
			?>
					<div
						class="availability_reserved"
						style="
							height:<?= $height ?>px;
							transform: translateY(<?= $translate ?>px);
						"
					></div>
			<?php } ?>
		</div>
	</div>
</div>
