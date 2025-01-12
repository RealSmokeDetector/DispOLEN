<?php

namespace App\Controllers\Reservations;

use App\Configs\Path;
use App\Models\Entities\Reservation;
use App\Models\Entities\User;
use App\Models\Repositories\ReservationRepository;
use App\Models\Repositories\UserRepository;

class ReservationsController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		$user = new User(uid: $_SESSION["user"]["uid"]);
		$reservation = new Reservation(user: $user);
		$reservationRepo = new ReservationRepository(reservation: $reservation);
		$reservations = $reservationRepo->getReservations();
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/reservations/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
