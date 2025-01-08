<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;

	var_dump(ApplicationData::getAllTeachers())
?>

<div>
	<p><?= Lang::translate(key: "MAIN_NAME")?> : </p>
	<p id="name"><?= $user["name"] ?></p>

	<p><?= Lang::translate(key: "MAIN_SURNAME")?> :</p>
	<p id="surname"><?= $user["surname"] ?></p>

	<p><?= Lang::translate(key: "MAIN_ROLE")?> : </p>
	<p id="role"><?= join(array: $rolesName, separator: " ") ?></p>
	<select id="roleSelect" style="display: none" multiple>
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
		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR")?> : <?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $userRepo->getTutor())["name"], surname: UserRepository::getInformations(uid: $userRepo->getTutor())["surname"])?></p>
	<?php } ?>

	<?php if (!empty(array_intersect($roles, [Role::TEACHER]))) { ?>
		<p id="tutor"><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT")?> : <?= join(array: $tutoredStudents, separator: " ") ?></p>
		<select id="tutorSelect">
			<?php foreach (ApplicationData::getAllTeachers() as $teacher) { ?>
				<option value="<?= $teacher ?>"
					<?= in_array(needle: $teacher, haystack: $roles) ? "selected" : "" ?>>
				</option>
			<?php } ?>
		</select>
	<?php } ?>

	<p><?= Lang::translate(key: "MAIN_EMAIL") ?> : <?= $user["email"]?></p>
	<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_DATE_CREATE")?> : <?= $user["date_create"]?></p>

	<button id="buttonId" >Modifier</button>
</div>
