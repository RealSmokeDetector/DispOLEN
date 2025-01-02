<?php
	use App\Utils\Lang;
?>

<form class="register" method="POST">
	<h1><i class="ri-user-line"></i> <?= Lang::translate("REGISTER_TITLE") ?></h1>

	<input
		type="text"
		name="name"
		value="<?= isset($_POST["name"]) ? $_POST["name"] : "" ?>"
		placeholder="<?= Lang::translate(key: "MAIN_NAME") ?>"
		required
		autofocus
	>
	<input
		type="text"
		name="surname"
		value="<?= isset($_POST["surname"]) ? $_POST["surname"] : "" ?>"
		placeholder="<?= Lang::translate(key: "MAIN_SURNAME") ?>"
		required
	>
	<input
		type="text"
		name="email"
		value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>"
		placeholder="<?= Lang::translate(key: "MAIN_EMAIL") ?>"
		required
	>

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

	<button class="submit" type="submit"><i class="ri-key-line"></i> <?= Lang::translate(key: "REGISTER_SUBMIT") ?></button>

	<a class="link" href="/login"><?= Lang::translate(key: "REGISTER_LOGIN") ?></a>
</form>
