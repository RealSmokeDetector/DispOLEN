<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<div>
	<form id="formUser" method="POST">

		<input type="hidden" name="uid" value="<?= $user["uid"]?>">
		<p><?= Lang::translate(key: "MAIN_NAME")?> : </p>
		<p id="name"><?= $user["name"] ?></p>

		<p><?= Lang::translate(key: "MAIN_SURNAME")?> :</p>
		<p id="surname"><?= $user["surname"] ?></p>

		<p><?= Lang::translate(key: "MAIN_ROLE")?> : </p>
		<p id="role"><?= join(array: $rolesName, separator: " ") ?></p>
		<select id="roleSelect" name="roles[]" style="display: none" multiple>
			<?php foreach (ApplicationData::getRoles() as $role) { ?>
				<option value="<?= $role ?>"
					<?= in_array(needle: $role, haystack: $roles) ? "selected" : "" ?>>
					<?= ApplicationData::roleFormat(id: $role) ?>
				</option>
			<?php } ?>
		</select>

		<?php if (!empty(array_intersect($roles, [Role::STUDENT]))) { ?>
			<p><?= Lang::translate(key: "MAIN_GROUP")?> : </p>
			<p><?= $userGroup ? ApplicationData::getGroupName(uid: $userGroup) : " "; ?></p>
			<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR")?> : </p>

			<p id="tutors"><?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $userRepo->getTutor())["name"], surname: UserRepository::getInformations(uid: $userRepo->getTutor())["surname"])?></p>
			<select id="tutorsSelect" name="tutor" style="display: none">
				<?php foreach ($teachers as $teacher) { ?>
					<option value="<?= $teacher ?>"
						<?= in_array(needle: $teacher, haystack: $teachers) ? "selected" : "" ?>>
						<?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $teacher)["name"], surname: UserRepository::getInformations(uid: $teacher)["surname"]) ?>
					</option>
				<?php } ?>
			</select>

		<?php } ?>

		<?php if (!empty(array_intersect($roles, [Role::TEACHER]))) { ?>

			<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT")?> : </p>
			<p id="tutoredStudents"><?= join(array: $tutoredStudents, separator: " ") ?></p>

			<select id="tutoredStudentsSelect" name="tutoredStudents" style="display: none">
				<?php foreach ($students as $student) { ?>
					<option value="<?= $student ?>"
						<?= in_array(needle: $student, haystack: $students) ? "selected" : "" ?>>
						<?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $student)["name"], surname: UserRepository::getInformations(uid: $student)["surname"]) ?>
					</option>
				<?php } ?>
			</select>

		<?php } ?>

		<p><?= Lang::translate(key: "MAIN_EMAIL") ?> : <?= $user["email"]?></p>
		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_DATE_CREATE")?> : <?= $user["date_create"]?></p>
	</form>
	<button id="buttonId">Modifier</button>
</div>
