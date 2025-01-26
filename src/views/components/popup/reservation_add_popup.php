<?php
	use App\Configs\Path;
?>

<div class="blur" id="reservation_popup" style="display: none">
	<div class="tile reservation_add_popup">
		<i class="ri-close-circle-line close_popup" id="close_popup"></i>
		<div class="item" id="reservation_element">
			<?php
				require Path::COMPONENTS . "/actions/calendar.php";
				require Path::COMPONENTS . "/tiles/timeslots_tile.php";
			?>
			<div id="reservation_time" style="display: none">
				<input type="time" id="start_time" required>
				<input type="time" id="end_time" required>
				<input type="hidden" id="uid_user" value="<?= $_SESSION["user"]["uid"] ?>">
				<button id="add_availability" > Valider </button>
			</div>
		</div>
	</div>
</div>
