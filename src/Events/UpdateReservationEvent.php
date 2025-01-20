<?php

namespace App\Events ;

use App\Models\Entities\Reservation;
use App\Models\Repositories\ReservationRepository;

class UpdateReservationEvent {
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			if (isset($_POST["submitAllForm"])) {
				$reservation = new Reservation(uid: $_POST["uid"], typeId: $_POST["type"], reasonId: $_POST["reason"], stateId:$_POST["state"], comment: $_POST["comment"]);
				$reservationRepo = new ReservationRepository(reservation: $reservation);
				$reservationRepo->update();
			}
			if (isset($_POST["action"]) && $_POST["action"] == "accept") {
				$reservation = new Reservation(uid: $_POST["uid"], stateId: 2);
				$reservationRepo = new ReservationRepository(reservation: $reservation);
				$reservationRepo->update();
			} else if (isset($_POST["action"]) && $_POST["action"] == "refuse") {
				$reservation = new Reservation(uid: $_POST["uid"], stateId: 3);
				$reservationRepo = new ReservationRepository(reservation: $reservation);
				$reservationRepo->update();
			} else if (isset($_POST["action"]) && $_POST["action"] == "cancel") {
				$reservation = new Reservation(uid: $_POST["uid"], stateId: 4);
				$reservationRepo = new ReservationRepository(reservation: $reservation);
				$reservationRepo->update();
			}

		}
	}
}

?>
