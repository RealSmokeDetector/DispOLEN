<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Factories\NavbarFactory;
use App\Models\Entities\Date;
use App\Models\Entities\Disponibility;
use App\Models\Entities\Reservation;
use App\Models\Entities\User;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\DisponibilityRepository;
use App\Models\Repositories\ReservationRepository;
use App\Utils\System;
use App\Models\Repositories\UserRepository;

class IndexController {
	public function render() : void {
		if (!isset($_SESSION["user"])) {
			System::redirect(url: "/login");
		}

		$user = new User(uid: $_SESSION["user"]["uid"]);
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);

		$dateRepo = new DateRepository(date: new Date());
		$offDays = DateRepository::getOffDays(year: $dateRepo->getYear());

		$reservationRepo = new ReservationRepository(reservation: new Reservation(user: $user));
		$reservations = $reservationRepo->getReservations();

		$disponibilityRepo = new DisponibilityRepository(disponibility: new Disponibility(user: $user));
		$disponibilities = $disponibilityRepo->getDisponibilities(date: $dateRepo);

		define(constant_name: "HEIGHT_TIMESLOTS_DIV", value: 306);

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/times/calendar.js",
			"/scripts/times/timeslots.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/index/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
