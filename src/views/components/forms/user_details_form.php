<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<form id="form_user" method="POST">
	<input type="hidden" name="uid" value="<?= $user["uid"] ?>">
	<p><?= Lang::translate(key: "MAIN_NAME") ?> : </p>
	<p id="name"><?= htmlspecialchars(string: $user["name"]) ?></p>

	<p><?= Lang::translate(key: "MAIN_SURNAME") ?> :</p>
	<p id="surname"><?= htmlspecialchars(string: $user["surname"]) ?></p>

	<p><?= Lang::translate(key: "MAIN_ROLE") ?> : </p>
	<p id="role"><?= join(array: $rolesName, separator: " ") ?></p>
	<select id="role_select" name="roles[]" style="display: none" multiple>
		<?php foreach (ApplicationData::getRoles() as $role) { ?>
			<option value="<?= $role ?>"
				<?= in_array(needle: $role, haystack: $roles) ? "selected" : "" ?>>
				<?= ApplicationData::roleFormat(id: $role) ?>
			</option>
		<?php } ?>
	</select>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) { ?>
		<p><?= Lang::translate(key: "MAIN_GROUP") ?> : </p>
		<p><?= htmlspecialchars(string: $userGroup ? ApplicationData::getGroupName(uid: $userGroup) : " ") ?></p>
		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR") ?> : </p>

		<p id="tutors"><?= $userRepo->getTutor() == null ? Lang::translate(key: "DASHBOARD_USER_DETAILS_NO_TUTOR") : ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $userRepo->getTutor())["name"], surname: UserRepository::getInformations(uid: $userRepo->getTutor())["surname"]) ?></p>
		<select id="tutors_select" name="tutor" style="display: none">
			<?php foreach ($teachers as $teacher) { ?>
				<option value="<?= htmlspecialchars(string: $teacher) ?>"
					<?= in_array(needle: $teacher, haystack: $teachers) ? "selected" : "" ?>>
					<?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $teacher)["name"], surname: UserRepository::getInformations(uid: $teacher)["surname"]) ?>
				</option>
			<?php } ?>
		</select>

	<?php } ?>

	<?php if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) { ?>

		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT") ?> : </p>
		<p id="tutored_students"><?= htmlspecialchars(string: join(array: $tutoredStudents, separator: " ")) ?></p>

		<select id="tutored_students_select" name="tutoredStudents[]" style="display: none" multiple>
			<?php foreach ($students as $student) { ?>
				<option value="<?= $student ?>"
					<?= in_array(needle: $student, haystack: $students) ? "selected" : "" ?>>
					<?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $student)["name"], surname: UserRepository::getInformations(uid: $student)["surname"]) ?>
				</option>
			<?php } ?>
		</select>

	<?php } ?>

	<p><?= Lang::translate(key: "MAIN_EMAIL") ?> : <?= $user["email"] ?></p>
	<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_DATE_CREATE") ?> : <?= $user["date_create"] ?></p>
</form>
