<?php
	use App\Utils\Lang;
?>

<form class="user_add_container" id="form_user" method="POST">
	<h1><i class="ri-user-line"></i> <?= Lang::translate(key: "REGISTER_TITLE") ?></h1>

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

	<button class="button submit" type="submit"><i class="ri-key-line"></i> <?= Lang::translate(key: "REGISTER_SUBMIT") ?></button>
</form>
