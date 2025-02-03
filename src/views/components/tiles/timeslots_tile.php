<?php
	use App\Models\Entities\Date;
	use App\Models\Repositories\DateRepository;
	use App\Models\Repositories\ReservationRepository;
	use App\Utils\Lang;
?>

	<div class="timeslots_container">
		<div class="times">
			<?php for ($hour = 8; $hour <= 19; $hour++) { ?>

			<p class="time"><?= date(format: "H:i", timestamp: strtotime(datetime: $hour . ":00")) ?></p>

			<?php
					$dateRepo->adjusteTimeMin(minute: 60);
				}
			?>
		</div>

		<div class="availabilities_container" id="availabilities_container">
			<?php for ($hour = 8; $hour <= 18; $hour++) { ?>
				<div class="availability" id="reservations" data-day="<?= $dateRepo->GetDate() ?>" data-hour="<?= $hour ?>"></div>
			<?php
				}

				foreach ($reservations as $reservation) {
					$reservationInfo = ReservationRepository::getInformation(uid: $reservation);

					$startDate = new DateRepository(date: new Date(timestamp: strtotime(datetime: $reservationInfo["date_start"])));

					if ($dateRepo->getDay() === $startDate->getDay()) {
						$endDate = new DateRepository(date: new Date(timestamp: strtotime(datetime: $reservationInfo["date_end"])));

						$height = (($startDate->getDurationDate(dateRepo: $endDate) / 60) * HEIGHT_TIMESLOTS_DIV) / (11 * 60);
						$translate = (($startDate->getIntervalFromBegin() / 60) * HEIGHT_TIMESLOTS_DIV) / (11 * 60);
			?>

				<div class="availability_reserved" style="height:<?= $height ?>px;transform: translateY(<?= $translate ?>px);"></div>

			<?php
					}
				}
			?>
		</div>
	</div>
