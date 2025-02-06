<?php
	use App\Configs\Path;
	use App\Models\Entities\Date;
	use App\Models\Repositories\DateRepository;
?>

<div class="calendar_container">
	<?php include Path::COMPONENTS . "/actions/calendar.php"; ?>

	<div class="tile timeslots">
		<?php
			$dateRepo = new DateRepository(date: new Date(timestamp: strtotime(datetime: "monday -1 week")));
			for ($i = 0; $i < 5; $i++) {
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
