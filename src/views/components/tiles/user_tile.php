<?php
	use App\Configs\Role;
	use App\Utils\ApplicationData;
?>

<a href="/dashboard/user/details?user=<?= $user["uid"] ?>">
	<div class="tile user_tile">
		<h2 class="name"><?= mb_strtoupper(string: htmlspecialchars(string: $user["surname"])) . " " . ucfirst(string: htmlspecialchars(string: $user["name"])) ?></h2>
		<p class="role"><?= htmlspecialchars(string: join(array: $rolesName, separator: " ")) ?></p>
		<?php if (!empty(array_intersect($roles, [Role::STUDENT]))) { ?>
		<p class="group"><i class="ri-team-line"></i> <?= htmlspecialchars(string: $userGroup ?? "") ? htmlspecialchars(string: ApplicationData::getGroupName(uid: $userGroup) ?? "") : " " ?></p>
		<?php } ?>
	</div>
</a>
