<?php
	use App\Utils\Lang;
?>

<div class="reservation_container">
	<h1><?= Lang::translate(key: "INDEX_RESERVATION_TITLE") ?></h1>
	<p><?= Lang::translate(key: "INDEX_RESERVATION_CONTENT") ?></p>

	<div>
		<?php for ($i = 0; $i < 3; $i++) { ?>
			<div>
				<p>row <?= $i + 1 ?></p>
				<a href="#"><?= Lang::translate(key: "MAIN_DETAIL") ?></a>
			</div>
		<?php } ?>

		<a href="#"><?= Lang::translate(key: "MAIN_SHOW_MORE") ?></a>
	</div>
</div>
