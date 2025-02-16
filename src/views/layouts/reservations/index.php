<?php
	use App\Configs\Path;
	use App\Configs\Role;
	use App\Models\Entities\Date;
	use App\Models\Repositories\DateRepository;
	use App\Models\Repositories\ReservationRepository;
	use App\Models\Repositories\UserRepository;
	use App\Utils\ApplicationData;
	use App\Utils\Roles;
?>

<h1 class="reservation_title"><i class="ri-calendar-2-line"></i> <?= $title ?></h1>

<?php include Path::COMPONENTS . "/actions/control_panel.php"; ?>

<div class="reservation_container">
	<?php
		foreach ($reservations as $iteration => $reservation) {
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

			include Path::COMPONENTS . "/tiles/reservation_tile.php";
		}
	?>
</div>

<?php include Path::COMPONENTS . "/actions/add_button.php"; ?>
