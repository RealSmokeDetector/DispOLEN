<?php
	use App\Configs\Path;
?>

<div class="blur" id="user_popup" style="display: none">
	<div class="tile user_add_popup">
		<i class="ri-close-circle-line close_popup" id="close_popup"></i>

		<?php include Path::COMPONENTS . "/forms/user_add_form.php"; ?>
	</div>
</div>
