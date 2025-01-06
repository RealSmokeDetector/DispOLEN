<?php
	use App\Configs\Role;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<a href="/dashboard/user/details?user=<?= $user["uid"] ?>">
	<div class="tile user_tile">
		<p><?= Lang::translate(key: "MAIN_NAME")?> : <?= $user["surname"] ?></p>
		<p><?= Lang::translate(key: "MAIN_SURNAME")?> : <?= $user["name"] ?></p>
		<p><?= Lang::translate(key: "MAIN_ROLE")?> : <?= join(array: $rolesName, separator: " ") ?></p>
		<?php if (!empty(array_intersect($roles, [Role::STUDENT]))) { ?>
		<p><?= Lang::translate(key: "MAIN_GROUP")?> : <?= $userGroup ? ApplicationData::getGroupName(uid: $userGroup) : " "; ?></p>
		<?php } ?>
	</div>
</a>
