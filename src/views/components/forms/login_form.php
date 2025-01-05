<?php
	use App\Utils\Lang;
?>

<form class="tile login" method="POST">
	<h1><i class="ri-lock-2-line"></i> <?= Lang::translate("LOGIN_TITLE") ?></h1>

	<input
		type="text"
		name="email"
		value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>"
		placeholder="<?= Lang::translate(key: "MAIN_EMAIL") ?>"
		required
		autofocus
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

	<button class="submit" type="submit"><i class="ri-key-line"></i> <?= Lang::translate(key: "LOGIN_SUBMIT") ?></button>

	<a class="link" href="/register"><?= Lang::translate(key: "LOGIN_REGISTER") ?></a>
</form>
