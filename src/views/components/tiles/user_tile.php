<?php
	use App\Configs\Role;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<a href="/dashboard/user/details?user=<?= $user["uid"] ?>">
	<div class="tile user_tile">
		<p><?= Lang::translate(key: "MAIN_NAME")?> : <?= htmlspecialchars(string: $user["surname"]) ?></p>
		<p><?= Lang::translate(key: "MAIN_SURNAME")?> : <?= htmlspecialchars(string: $user["name"]) ?></p>
		<p><?= Lang::translate(key: "MAIN_ROLE")?> : <?= htmlspecialchars(string: join(array: $rolesName, separator: " ")) ?></p>
		<?php if (!empty(array_intersect($roles, [Role::STUDENT]))) { ?>
		<p><?= Lang::translate(key: "MAIN_GROUP")?> : <?= htmlspecialchars(string: $userGroup ?? "") ? htmlspecialchars(string: ApplicationData::getGroupName(uid: $userGroup) ?? "") : " "; ?></p>
		<?php } ?>
	</div>
</a>
