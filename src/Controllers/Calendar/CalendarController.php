<?php

namespace App\Controllers\Calendar;

use App\Configs\Path;
use App\Factories\NavbarFactory;
use App\Models\Entities\Date;
use App\Models\Entities\Reservation;
use App\Models\Entities\User;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\ReservationRepository;

class CalendarController {
	public function render() : void {
		$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $_SESSION["user"]["uid"])));
		$reservations = $reservationRepo->getReservations();

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/times/calendar.js",
			"/scripts/times/timeslots.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		define(constant_name: "HEIGHT_TIMESLOTS_DIV", value: 306);

		$dateRepo = new DateRepository(date: new Date());
		$offDays = DateRepository::getOffDays(year: $dateRepo->getYear());

		require Path::LAYOUT . "/calendar/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
