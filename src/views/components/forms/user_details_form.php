<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;
?>

<form id="form_user" method="POST">
	<input type="hidden" name="uid" value="<?= $user["uid"] ?>">

	<div class="up">
		<div class="left">
			<h2><?= Lang::translate(key: "MAIN_NAME") ?></h2>
			<p id="name"><?= htmlspecialchars(string: $user["name"]) ?></p>

			<h2><?= Lang::translate(key: "MAIN_SURNAME") ?></h2>
			<p id="surname"><?= htmlspecialchars(string: $user["surname"]) ?></p>

			<h2><?= Lang::translate(key: "MAIN_EMAIL") ?></h2>
			<p><?= $user["email"] ?></p>
		</div>

		<div class="right">
			<h2><?= Lang::translate(key: "MAIN_ROLE") ?></h2>
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

				<h2><?= Lang::translate(key: "MAIN_GROUP") ?></h2>
				<p><?= htmlspecialchars(string: $userGroup ? ApplicationData::getGroupName(uid: $userGroup) : " ") ?></p>

				<h2><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR") ?></h2>
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

				<h2><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT") ?></h2>
				<p id="tutored_students"><?= join(array: $tutoredStudentsName, separator: "<br>") ?></p>

				<select id="tutored_students_select" name="tutoredStudents[]" style="display: none" multiple>
					<?php
						foreach ($students as $student) {
							$studentInfo = UserRepository::getInformations(uid: $student);
					?>
						<option value="<?= $student ?>"
							<?= in_array(needle: $student, haystack: $tutoredStudents) ? "selected" : "" ?>>
							<?= ApplicationData::nameFormat(name: $studentInfo["name"], surname: $studentInfo["surname"]) ?>
						</option>
					<?php } ?>
				</select>

			<?php } ?>
		</div>
	</div>

	<div class="line"></div>

	<h2><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_DATE_CREATE") ?></h2>
	<p><?= $dateRepo->getDate() . " " . $dateRepo->getTime() ?></p>
</form>
