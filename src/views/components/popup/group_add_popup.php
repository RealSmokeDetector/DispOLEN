<?php
	use App\Configs\Path;
?>

<div class="blur" id="group_popup" style="display: none">
	<div class="tile group_add_popup">
		<i class="ri-close-circle-line close_popup" id="close_popup"></i>

		<?php include Path::COMPONENTS . "/forms/group_add_popup_form.php"; ?>
	</div>
</div>
