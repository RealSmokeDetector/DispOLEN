<?php
	use App\Utils\Lang;
?>

<form class="group_add_container" method="POST">
	<input name="group_name" type="text" placeholder="<?= Lang::translate(key: "MAIN_OBJECT_NAME") ?>">
	<button class="button submit" type="submit"><?= Lang::translate(key: "MAIN_ADD") ?></button>
</form>
