<?php
	use App\Configs\Path;
	use App\Models\Entities\Date;
	use App\Models\Repositories\DateRepository;
?>

<div class="calendar_container">
	<?php include Path::COMPONENTS . "/actions/calendar.php"; ?>

	<div class="tile timeslots" id="timeslots_tile" data-uid="<?= $_SESSION["user"]["uid"]?>">
		<?php
			for ($i = 0; $i < 5; $i++) {
				$disponibilities = $disponibilityRepo->getDisponibilities(date: $dateRepo);

				include Path::COMPONENTS . "/tiles/timeslots_tile.php";

				if ($dateRepo->getDayNumber() === $dateRepo->getDay() && $dateRepo->getMonth() === 12) {
					$date = new Date(timestamp: strtotime(datetime: $dateRepo->getYear() + 1) . "-01-01");
				} else if ($dateRepo->getDayNumber() === $dateRepo->getDay()) {
					$date = new Date(timestamp: strtotime(datetime: $dateRepo->getYear() . "-" . ($dateRepo->getMonth() + 1) . "-1"));
				} else {
					$date = new Date(timestamp: strtotime(datetime: $dateRepo->getYear() . "-" . $dateRepo->getMonth() . "-" . ($dateRepo->getDay() + 1)));
				}

				$dateRepo = new DateRepository(date: $date);
			}
		?>
	</div>
</div>
