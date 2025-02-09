<?php
	use App\Utils\Lang;
?>

<div class="tile control_panel">
	<div class="controls">
		<button class="button" id="control_panel_before"><i class="ri-skip-left-line"></i></button>
		<button class="button button_secondary" id="control_panel_before">1</button>
		<button class="button" id="control_panel_after"><i class="ri-skip-right-line"></i></button>
	</div>

	<div class="filters">
		<input type="text" placeholder="<?= Lang::translate(key: "MAIN_SEARCH") ?>">

		<select id="control_panel_filter">
			<option value="a-z">A-Z</option>
			<option value="z-a">Z-A</option>
		</select>
	</div>
</div>
