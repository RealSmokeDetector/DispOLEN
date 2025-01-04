<?php
	use App\Utils\Lang;

	$title = Lang::translate(key: "INDEX_RESERVATION_TITLE");
	$paragraphe = Lang::translate(key: "INDEX_RESERVATION_CONTENT");
	$showMore = Lang::translate(key: "MAIN_SHOW_MORE");
	$detail = Lang::translate(key: "MAIN_DETAIL");
?>

<div class="resertion-container">
	<h3><?= $title ?></h3>
	<p><?= $paragraphe ?></p>
	<div>
		<?php for ($i = 0; $i < 3; $i++) { ?>
			<div>
				<p>row <?= $i + 1 ?></p>
				<a href='#'><?= $detail ?></a>
			</div>
		<?php } ?>
		<a href="#"><?= $showMore ?></a>
	</div>
</div>
