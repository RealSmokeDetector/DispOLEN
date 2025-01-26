<?php

namespace App\Controllers\Reservations;

use App\Configs\Path;
use App\Factories\NavbarFactory;
use App\Models\Entities\Reservation;
use App\Models\Entities\User;
use App\Models\Repositories\ReservationRepository;
use App\Models\Repositories\UserRepository;

class ReservationsController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/reservations/popup.js",
			"/scripts/times/calendar.js"
		];

		$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $_SESSION["user"]["uid"])));
		$reservations = $reservationRepo->getReservations();
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);

		require Path::LAYOUT . "/header.php";

		require Path::COMPONENTS . "/popup/reservation_add_popup.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/reservations/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
