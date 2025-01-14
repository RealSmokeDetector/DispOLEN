<?php

namespace App\Events ;

use App\Models\Entities\Reservation;
use App\Models\Repositories\ReservationRepository;

class UpdateReservationEvent {
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$reservation = new Reservation(uid: $_POST["uid"], typeId: $_POST["type"], reasonId: $_POST["reason"], stateId:$_POST["state"], comment: $_POST["comment"]);
			$reservationRepo = new ReservationRepository(reservation: $reservation);
			$reservationRepo->update();
		}
	}
}

?>
