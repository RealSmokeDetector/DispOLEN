<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Entities\Date;
	use App\Models\Repositories\DateRepository;
	use App\Models\Repositories\ReservationRepository;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Lang;
	use App\Utils\Roles;

	$title = Lang::translate(key: "INDEX_RESERVATION_TITLE_TEACHER");
	if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) {
		$title = Lang::translate(key: "INDEX_RESERVATION_TITLE_STUDENT");
	}
?>

<h1 class="reservation_title"><i class="ri-calendar-2-line"></i> <?= $title ?></h1>

<div class="reservation_container">
	<?php
		foreach ($reservations as $reservation) {
			$reservationInfo = ReservationRepository::getInformation(uid: $reservation);

			if (Roles::check(userRoles: $roles, allowRoles: [Role::STUDENT])) {
				$userInformation = UserRepository::getInformations(uid: $reservationInfo["uid_teacher"]);
				$name = ApplicationData::nameFormat(name: $userInformation["name"], surname: $userInformation["surname"], complete: false, toChange: 1);
			}

			if (Roles::check(userRoles: $roles, allowRoles: [Role::TEACHER])) {
				$userInformation = UserRepository::getInformations(uid: $reservationInfo["uid_student"]);
				$name = mb_strtoupper(string: $userInformation["surname"]) . " " . ucfirst(string: $userInformation["name"]);
			}

			$startDate = new DateRepository(date: new Date(timestamp: strtotime(datetime: $reservationInfo["date_start"])));
			$endDate = new DateRepository(date: new Date(timestamp: strtotime(datetime: $reservationInfo["date_end"])));

			include Path::COMPONENTS . "/tiles/reservation_details_tile.php";
		}
	?>
</div>

<button class="button add_button" id="edit_button">+</button>
