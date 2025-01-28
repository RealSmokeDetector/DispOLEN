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

		$userRepo = new UserRepository(user: new User(uid: $_SESSION["user"]["uid"]));
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);
		$reservationRepo = new ReservationRepository(reservation: new Reservation(uid: $_GET["reservation"]));
		$reservationData = $reservationRepo->getInformation();
		$states = ApplicationData::getStates();
		$reasons = ApplicationData::getReasons();
		$types = ApplicationData::getTypes();
		$infoStudent = UserRepository::getInformations(uid: $reservationData["uid_student"]);
		$infoTeacher = UserRepository::getInformations(uid: $reservationData["uid_teacher"]);

		$date_start = new Date(date: $reservationData["date_start"]);
		$date_end = new Date(date: $reservationData["date_end"]);

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

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/reservations/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
