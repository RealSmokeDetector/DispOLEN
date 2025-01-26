<?php
	use App\Configs\Path;
?>

<div class="blur" id="reservation_popup" style="display: none">
	<div class="tile reservation_add_popup">
		<i class="ri-close-circle-line close_popup" id="close_popup"></i>
		<div class="item">
			<?php require Path::COMPONENTS . "/actions/calendar.php"; ?>
			TimeSlots
		</div>
	</div>
</div>
