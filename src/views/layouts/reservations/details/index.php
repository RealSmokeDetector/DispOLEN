<?php
	use App\Configs\Path;
	use App\Utils\Lang;
?>

<?php
	$backPath = "/reservations";
	include Path::COMPONENTS . "/actions/back_button.php"
?>

<h1 class="reservation_details_title"><?= Lang::translate(key: "RESERVATIONS_DETAILS_TITLE") ?></h1>

<?php include Path::COMPONENTS . "/tiles/reservation_details_tile.php" ?>
