<?php

namespace App\Controllers\Reservations;

use App\Configs\Path;
use App\Factories\NavbarFactory;
use App\Models\Entities\Date;
use App\Models\Entities\Reservation;
use App\Models\Entities\User;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\ReservationRepository;
use App\Models\Repositories\UserRepository;

class ReservationsController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/reservations/popup.js",
			"/scripts/times/calendar.js",
			"/scripts/reservations/timeslot.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $_SESSION["user"]["uid"])));
		$reservations = $reservationRepo->getReservations();
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);
		define(constant_name: "HEIGHT_TIMESLOTS_DIV", value: 306);
		$dateRepo = new DateRepository(date: new Date());
		$offDays = DateRepository::getOffDays(year: $dateRepo->getYear());

		require Path::LAYOUT . "/header.php";

		require Path::COMPONENTS . "/popup/reservation_add_popup.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/reservations/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
