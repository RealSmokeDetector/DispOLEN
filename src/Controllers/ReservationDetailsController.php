<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Utils\System;
use App\Models\Reservation;
use App\Models\Repositories\ReservationRepository;

class ReservationDetailsController {
	public function render() : void {
		$reservation= new Reservation();//TODO UID
		$reservationRepo= new ReservationRepository($reservation);
		$reservationData= $reservationRepo->getInformation();

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/reservations/details/index.php";

		System::implementScripts(scripts: ["/scripts/engine.js", "/scripts/theme.js"]);

		include Path::LAYOUT . "/footer.php";
	}
}
	