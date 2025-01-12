<?php
	use App\Configs\Path;
?>

<div class="index_container">
	<?php
		require Path::COMPONENTS . "/tiles/reservation_tile.php";
		require Path::COMPONENTS . "/actions/calendar.php";
		require Path::COMPONENTS . "/tiles/timeslots_tile.php";
	?>
</div>
