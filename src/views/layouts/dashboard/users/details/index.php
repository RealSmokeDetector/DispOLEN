<?php
	use App\Configs\Path;
	use App\Utils\Lang;
?>

<?php
	$backPath = "/dashboard/users";
	include Path::COMPONENTS . "/actions/back_button.php"
?>

<div class="tile user_details_container">
	<?php include Path::COMPONENTS . "/forms/user_details_form.php"; ?>

	<button class="button" id="button_id"><?= Lang::translate(key: "MAIN_MODIFY") ?></button>
</div>
