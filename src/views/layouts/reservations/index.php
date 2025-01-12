<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
?>

<div class="reservation_container">
	<?php
		foreach ($reservations as $reservation) {
			if (!empty(array_intersect($roles, [Role::STUDENT]))) {
				$userInformation = UserRepository::getInformations(uid: $reservation["uid_teacher"]);
				$name = Lang::translate(key: "RESERVATION_TEACHER_NAME") . " : " . ApplicationData::nameFormat(name: $userInformation["name"], surname: $userInformation["surname"], complete: false, toChange: 1);
			}
			if (!empty(array_intersect($roles, [Role::TEACHER]))) {
				$userInformation = UserRepository::getInformations(uid: $reservation["uid_student"]);
				$name = Lang::translate(key: "RESERVATION_STUDENT_NAME") . " : " . ApplicationData::nameFormat(name: $userInformation["name"], surname: $userInformation["surname"], reverse:true);
			}

			include Path::COMPONENTS . "/tiles/reservation_details_tile.php";
		}
	?>
</div>
