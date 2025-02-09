<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<form class="account_modify" method="POST">
	<h1><?= Lang::translate(key: "ACCOUNT_MODIFY_TITLE") ?></h1>

	<h2><?= ucfirst(string: htmlspecialchars(string: $userInfo["name"])) ?> <?= ucfirst(string: htmlspecialchars(string: $userInfo["surname"])) ?></h2>
	<p><?= htmlspecialchars(string: $userInfo["email"]) ?></p>
	<p id="role"><i class="ri-bank-card-line"></i> <?= join(array: $rolesName, separator: ", ") ?></p>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) { ?>
		<p><i class="ri-team-line"></i> <?= htmlspecialchars(string: $userGroup == null ? Lang::translate(key: "ACCOUNT_NO_GROUP") : ApplicationData::getGroupName(uid: $userGroup)) ?></p>

		<div class="line"></div>

		<h2><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR") ?></h2>

		<p id="tutors"><?= $userRepo->getTutor() == null ? Lang::translate(key: "ACCOUNT_NO_TUTOR") : htmlspecialchars(string: ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $userRepo->getTutor())["name"], surname: UserRepository::getInformations(uid: $userRepo->getTutor())["surname"])) ?></p>
	<?php } ?>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) { ?>

	<div class="line"></div>

	<h2><i class="ri-user-line"></i> <?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT") ?></h2>
	<p id="tutored_students"><?= join(array: $tutoredStudents, separator: "<br>") ?></p>

	<?php } ?>

	<div id="modify_password" style="display: none">
		<div class="line"></div>

		<h2><?= Lang::translate(key: "ACCOUNT_MODIFY_PASSWORD") ?></h2>

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

		<button class="button" type="submit" id="save_button"><?= Lang::translate(key: "MAIN_SAVE")?></button>
	</div>

</form>

<button class="button" id="button_id"><?= Lang::translate(key: "MAIN_MODIFY") ?></button>
