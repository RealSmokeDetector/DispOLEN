<?php
	use App\Configs\Path;
	use App\Utils\Lang;
?>

<div class="index_container">
	<?php require Path::COMPONENTS . "/tiles/reservation_tile.php"; ?>
	<?php require Path::COMPONENTS . "/actions/calendar.php"; ?>

	<div class="tile timeslots_tile" id="timeslots_tile" data-uid="<?= $_SESSION["user"]["uid"]?>">
		<h1 class="title"><?= Lang::translate(key: "TIMESLOTS_TITLE") ?></h1>
		<p class="title" id="timesolt_date"><?= $dateRepo->convertDate() ?></p>

		<div class="line"></div>

		<?php require Path::COMPONENTS . "/tiles/timeslots_tile.php"; ?>
	</div>
</div>
