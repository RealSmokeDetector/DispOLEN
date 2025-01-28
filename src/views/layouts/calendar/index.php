<?php
	use App\Configs\Path;
?>

<div class="calendar_container">
	<?php
		include Path::COMPONENTS . "/actions/calendar.php";

		for($i = 0; $i < 5; $i++) {
			include Path::COMPONENTS . "/tiles/timeslots_tile.php";
		}
	?>
</div>
