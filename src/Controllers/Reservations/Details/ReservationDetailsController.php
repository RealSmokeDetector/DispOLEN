<?php

namespace App\Controllers\Reservations\Details;

use App\Configs\Path;
use App\Models\Entities\Reservation;
use App\Models\Repositories\ReservationRepository;
use App\Utils\System;

class ReservationDetailsController {
	public function render() : void {
		$reservation = new Reservation(uid: $_GET["reservation"]);
		$reservationRepo = new ReservationRepository(reservation: $reservation);
		$reservationData = $reservationRepo->getInformation();

		if (
			!isset($_GET["reservation"])
			|| $_GET["reservation"] === ""
			|| $reservationData === null
		) {
			System::redirect(url: "/reservations");
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/reservations/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
