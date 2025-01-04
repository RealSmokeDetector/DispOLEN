<?php
	use App\Utils\Lang;

	$title = 		Lang::translate(key: "REGISTRY_HEADLINE");
	$paragraphe = 	Lang::translate(key: "REGISTRY_CONTENT");
	$showMore = 	Lang::translate(key: "REGSTERY_SHOW_MORE");
	$detail = 		Lang::translate(key: "REGSTERY_DETAIL");
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
