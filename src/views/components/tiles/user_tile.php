<?php
	use App\Configs\Role;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<a id="user_tile" href="/dashboard/user/details?user=<?= $user["uid"] ?>">
	<div class="tile user_tile">
		<h2 class="name"><?= mb_strtoupper(string: htmlspecialchars(string: $user["surname"])) . " " . ucfirst(string: htmlspecialchars(string: $user["name"])) ?></h2>
		<p class="role"><?= htmlspecialchars(string: join(array: $rolesName, separator: " ")) ?></p>

		<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) { ?>

		<p class="subtitle" title="<?= Lang::translate(key: "MAIN_GROUP") ?>"><i class="ri-team-line"></i> <?= htmlspecialchars(string: $userGroup ?? "") ? htmlspecialchars(string: ApplicationData::getGroupName(uid: $userGroup) ?? "") : " " ?></p>

		<?php
			}
			if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) {
		?>

		<p class="subtitle" title="<?= Lang::translate(key: "MAIN_STUDENT") ?>"><i class="ri-user-line"></i> <?= count(value: $userRepo->getTutoredStudent()) ?></p>

		<?php } ?>
	</div>
</a>
