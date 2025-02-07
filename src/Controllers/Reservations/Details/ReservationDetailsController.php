<?php

namespace App\Controllers\Reservations\Details;

use App\Configs\Path;
use App\Events\UpdateReservationEvent;
use App\Factories\NavbarFactory;
use App\Models\Entities\Date;
use App\Models\Entities\Reservation;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\ReservationRepository;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use App\Utils\System;

class ReservationDetailsController {
	public function render() : void {
		UpdateReservationEvent::implement();

		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);

		$reservationRepo = new ReservationRepository(reservation: new Reservation(uid: $_GET["reservation"]));
		$reservationInfo = ReservationRepository::getInformation(uid: $_GET["reservation"]);

		$infoStudent = UserRepository::getInformations(uid: $reservationInfo["uid_student"]);
		$infoTeacher = UserRepository::getInformations(uid: $reservationInfo["uid_teacher"]);

		$startDate = new DateRepository(date: new Date(timestamp: strtotime(datetime: $reservationInfo["date_start"])));
		$endDate = new DateRepository(date: new Date(timestamp: strtotime(datetime: $reservationInfo["date_end"])));

		$reasons = ApplicationData::getReasons();
		$types = ApplicationData::getTypes();

		if (
			!isset($_GET["reservation"])
			|| $_GET["reservation"] === ""
			|| $reservationInfo === null
		) {
			System::redirect(url: "/reservations");
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/reservations/edit.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/reservations/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
