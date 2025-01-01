<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\Lang;
?>

<nav>
	<div class="item">
		<a class="button button_secondary" href="/"><i class="ri-home-2-line"></i> <?= Lang::translate(key: "NAVBAR_HOME") ?></a>
	</div>

<?php if (!isset($_SESSION["user"])) { ?>

	<div class="item">
		<a class="button" href="/login"><i class="ri-lock-2-line"></i> <?= Lang::translate(key: "NAVBAR_LOGIN") ?></a>
	</div>
	<div class="item">
		<a class="button" href="/register"><i class="ri-user-line"></i> <?= Lang::translate(key: "NAVBAR_REGISTER") ?></a>
	</div>

<?php } else { ?>

<?php if (!empty(array_intersect(UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), [Role::ADMINISTRATOR]))) { ?>

	<div class="item">
		<a class="button" href="/dashboard"><i class="ri-dashboard-3-line"></i> <?= Lang::translate(key: "NAVBAR_DASHBOARD") ?></a>
	</div>

<?php } ?>

	<div class="item">
		<a class="button" href="/disconnect"><i class="ri-logout-box-r-line"></i> <?= Lang::translate(key: "NAVBAR_DISCONNECT") ?></a>
	</div>
	<div class="item">
		<a class="profil_button" href="" title="<?= Lang::translate(key: "NAVBAR_PROFILE") ?>"><i class="ri-account-circle-2-line"></i></a>
	</div>

<?php } ?>

	<div class="item">
		<?php include Path::COMPONENTS . "/actions/theme_button.php"; ?>
	</div>
	<div class="item">
		<?php include Path::COMPONENTS . "/actions/lang_selection.php"; ?>
	</div>
</nav>
