<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Models\Reservation;
use App\Models\Repositories\ReservationRepository;

class ReservationDetailsController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		$reservation= new Reservation();//TODO UID
		$reservationRepo= new ReservationRepository($reservation);
		$reservationData= $reservationRepo->getInformation();

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/reservations/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
