<?php
	use App\Utils\Lang;
?>

<form class="tile modify_container" method="POST">
	<h1><?= Lang::translate(key: "MODIFY_FIRST_CONNECTION") ?></h1>

	<div class="password" id="password">
		<input
			type="password"
			name="password"
			value="<?= isset($_POST["password"]) ? $_POST["password"] : "" ?>"
			placeholder="<?= Lang::translate(key: "MAIN_PASSWORD") ?>"
			required
		>
		<i class="ri-eye-off-line"></i>
	</div>
	<div class="password" id="password">
		<input
			type="password"
			name="password_confirm"
			value="<?= isset($_POST["password_confirm"]) ? $_POST["password_confirm"] : "" ?>"
			placeholder="<?= Lang::translate(key: "REGISTER_PASSWORD_CONFIRM") ?>"
			required
		>
		<i class="ri-eye-off-line"></i>
	</div>

	<button class="button"><?= Lang::translate(key: "MAIN_MODIFY") ?></button>
</form>
