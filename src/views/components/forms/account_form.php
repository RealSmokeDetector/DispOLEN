<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<form class="tile account_modify" method="POST">
	<h1><?= Lang::translate(key: "ACCOUNT_MODIFY_TITLE") ?></h1>

	<p><?= Lang::translate(key: "MAIN_NAME") ?></p>
	<p><?= htmlspecialchars(string: $user["name"]) ?></p>
	<p><?= Lang::translate(key: "MAIN_SURNAME") ?></p>
	<p><?= htmlspecialchars(string: $user["surname"]) ?></p>
	<p><?= Lang::translate(key: "MAIN_EMAIL") ?></p>
	<p><?= htmlspecialchars(string: $user["email"]) ?></p>
	<p><?= Lang::translate(key: "MAIN_ROLE") ?></p>
	<p id="role"><?= join(array: $rolesName, separator: " ") ?></p>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) { ?>
		<p><?= Lang::translate(key: "MAIN_GROUP") ?> : </p>
		<p><?= htmlspecialchars(string: $userGroup ? ApplicationData::getGroupName(uid: $userGroup) : " ") ?></p>
		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR") ?> : </p>

		<p id="tutors"><?= $userRepo->getTutor() == null ? Lang::translate(key: "ACCOUNT_NO_TUTOR") : ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $userRepo->getTutor())["name"], surname: UserRepository::getInformations(uid: $userRepo->getTutor())["surname"]) ?></p>
	<?php } ?>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) { ?>

	<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT") ?> : </p>
	<p id="tutored_students"><?= htmlspecialchars(string: join(array: $tutoredStudents, separator: " ")) ?></p>

	<?php } ?>

	<div class="password" id="password" style="display: none">
		<input
			type="password"
			name="password"
			value="<?= isset($_POST["password"]) ? $_POST["password"] : "" ?>"
			placeholder="<?= Lang::translate(key: "MAIN_PASSWORD") ?>"
			required
		>
		<i class="ri-eye-off-line"></i>
	</div>
	<div class="password" id="password" style="display: none">
		<input
			type="password"
			name="password_confirm"
			value="<?= isset($_POST["password_confirm"]) ? $_POST["password_confirm"] : "" ?>"
			placeholder="<?= Lang::translate(key: "REGISTER_PASSWORD_CONFIRM") ?>"
			required
		>
		<i class="ri-eye-off-line"></i>
	</div>

	<button class="button" type="submit" id="save_button" style="display : none"><?= Lang::translate(key: "MAIN_SAVE")?></button>
</form>

<button class="button" id="button_id"><?= Lang::translate(key: "MAIN_MODIFY") ?></button>
