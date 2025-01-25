<?php
	use App\Utils\Lang;
?>

<form class="tile account_modify" method="POST">
	<h1><?= Lang::translate(key: "ACCOUNT_MODIFY_TITLE") ?></h1>

	<button class="button" type="submit"><?= Lang::translate(key: "MAIN_SAVE")?></button>
</form>
