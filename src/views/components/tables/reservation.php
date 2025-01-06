<?php
	use App\Utils\Lang;
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
?>

<div class="tile reservation_container">
	<h1><?= (!empty(array_intersect(UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), [Role::STUDENT])))? Lang::translate(key: "INDEX_RESERVATION_TITLE_STUDENT"): Lang::translate(key: "INDEX_RESERVATION_TITLE_TEACHER") ?></h1>
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
