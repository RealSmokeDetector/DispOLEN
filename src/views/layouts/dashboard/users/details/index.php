<?php
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<div>
	<p><?= Lang::translate(key: "MAIN_NAME")?> : <?= $user["surname"] ?></p>
	<p><?= Lang::translate(key: "MAIN_SURNAME")?> : <?= $user["name"] ?></p>
	<p><?= Lang::translate(key: "MAIN_ROLE")?> : <?= join(array: $rolesName, separator: " ") ?></p>

	<?php if (!empty(array_intersect($roles, [Role::STUDENT]))) { ?>
		<p><?= Lang::translate(key: "MAIN_GROUP")?> : <?= $userGroup ? ApplicationData::getGroupName(uid: $userGroup) : " "; ?></p>
		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTOR")?> : <?= ApplicationData::nameFormat(name: UserRepository::getInformations(uid: $userRepo->getTutor())["name"], surname: UserRepository::getInformations(uid: $userRepo->getTutor())["surname"])?></p>
	<?php } ?>

	<?php if (!empty(array_intersect($roles, [Role::TEACHER]))) { ?>
		<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_TUTORED_STUDENT")?> <?= join(array: $tutoredStudents, separator: " ") ?></p>
	<?php } ?>
	
	<p><?= Lang::translate(key: "MAIN_EMAIL") ?> : <?= $user["email"]?></p>
	<p><?= Lang::translate(key: "DASHBOARD_USER_DETAILS_DATE_CREATE")?> : <?= $user["date_create"]?></p>
</div>
