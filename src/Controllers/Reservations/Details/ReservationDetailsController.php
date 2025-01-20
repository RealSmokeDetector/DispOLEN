<?php

namespace App\Controllers\Reservations\Details;

use App\Configs\Path;
use App\Events\UpdateReservationEvent;
use App\Factories\NavbarFactory;
use App\Models\Entities\Reservation;
use App\Models\Entities\User;
use App\Models\Repositories\ReservationRepository;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use App\Utils\Date;
use App\Utils\System;

class ReservationDetailsController {
	public function render() : void {
		UpdateReservationEvent::implement();

		$userEntity = new User($_SESSION["user"]["uid"]) ;
		$userRepo = new UserRepository(user: $userEntity);
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);
		$reservation = new Reservation(uid: $_GET["reservation"]);
		$reservationRepo = new ReservationRepository(reservation: $reservation);
		$reservationData = $reservationRepo->getInformation();
		$states = ApplicationData::getStates();
		$reasons = ApplicationData::getReasons();
		$types = ApplicationData::getTypes();
		$infoStudent = UserRepository::getInformations(uid: $reservationData["uid_student"]);
		$infoTeacher = UserRepository::getInformations(uid: $reservationData["uid_teacher"]);

		$date_start = new Date(date: ReservationRepository::getStartDate(disponibilityUid: $reservationData["uid_disponibilities"]));
		$date_end = new Date(date: ReservationRepository::getEndDate(disponibilityUid: $reservationData["uid_disponibilities"]));

		if (
			!isset($_GET["reservation"])
			|| $_GET["reservation"] === ""
			|| $reservationData === null
		) {
			System::redirect(url: "/reservations");
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/reservations/edit.js"
		];

		require Path::LAYOUT . "/header.php";

		new NavbarFactory();

		require Path::LAYOUT . "/reservations/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
