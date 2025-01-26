<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Repositories\ReservationRepository;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Date;
	use App\Utils\Lang;
	use App\Utils\Roles;

	$title = Lang::translate(key: "INDEX_RESERVATION_TITLE_TEACHER");
	if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) {
		$title = Lang::translate(key: "INDEX_RESERVATION_TITLE_STUDENT");
	}
?>

<h1 class="reservation_title"><i class="ri-calendar-2-line"></i> <?= $title ?></h1>

<button class="button" id="edit_button">+</button>

<div class="reservation_container">
	<?php
		foreach ($reservations as $reservation) {
			if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) {
				$userInformation = UserRepository::getInformations(uid: $reservation["uid_teacher"]);
				$name = ApplicationData::nameFormat(name: $userInformation["name"], surname: $userInformation["surname"], complete: false, toChange: 1);
			}

			if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) {
				$userInformation = UserRepository::getInformations(uid: $reservation["uid_student"]);
				$name = mb_strtoupper(string: $userInformation["surname"]) . " " . ucfirst(string: $userInformation["name"]);
			}

			$date_start = new Date(date: ReservationRepository::getStartDate(disponibilityUid: $reservation["uid_disponibilities"]));
			$date_end = new Date(date: ReservationRepository::getEndDate(disponibilityUid: $reservation["uid_disponibilities"]));

			include Path::COMPONENTS . "/tiles/reservation_details_tile.php";
		}
	?>
</div>
