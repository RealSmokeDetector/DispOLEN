<?php
	use App\Configs\Path;
	use App\Utils\Date;
?>

<div class="calendar_container">
	<?php
		include Path::COMPONENTS . "/actions/calendar.php";
		$dateOutOffBounts = new Date();
		for($i = 0; $i < 5; $i++) {
			include Path::COMPONENTS . "/tiles/timeslots_tile.php";
			if ($dateOutOffBounts->getNbDayMonth() === $date->day &&  $date->month === 12) {
				$date = new Date ( date: ($date->year + 1) . "-01-01");
			} else if ($dateOutOffBounts->getNbDayMonth() === $date->day) {
				$date = new Date ( date: $date->year . "-" . ($date->month + 1) . "-1");
			} else {
				$date = new Date ( date: $date->year . "-" . $date->month . "-" . ($date->day + 1));
			}
		}
	?>
</div>
