<?php
	use App\Configs\Path;
	use App\Utils\Lang;
?>

<div class="tile user_details_container">
	<?php include Path::COMPONENTS . "/forms/user_details_form.php"; ?>

	<button class="button" id="button_id"><?= Lang::translate(key: "MAIN_MODIFY") ?></button>
</div>
