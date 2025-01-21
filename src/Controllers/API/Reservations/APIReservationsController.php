<?php

namespace App\Controllers\API\Reservations;

use App\Models\Entities\API;
use App\Models\Entities\User;
use App\Models\Entities\Reservation;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\ReservationRepository;
use App\Utils\Date;

class APIReservationsController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch($_SERVER["REQUEST_METHOD"]) {
			case "GET":

				$json = file_get_contents(filename: "php://input");
				$body = $_GET;

				if (isset($body['uid']) && isset($body['date_start'])) {
					$data = [];
					$user = new User(uid: $body['uid']);
					$reservation = new Reservation();
					$reservation->user = $user;
					$reservationRepo = new ReservationRepository(reservation: $reservation);
					$date = new Date(date: $body['date_start']);
					foreach ($reservationRepo->reservationByDate(dateStart: $date) as $resa) {
						array_push($data, $resa);
					}
				} else {
					http_response_code(response_code: 400);

					$data["error"] = "Invalid request";
					$data["description"] = "Unspecified date.";
				}
				$api = new API(data: $data);
				break;
			default:
				http_response_code(response_code: 404);

				$data["error"] = "Not found";
				$data["description"] = "Unknown API call.";

				$api = new API(data: $data);
				break;
		}

		$apiRepo = new APIRepository(api: $api);
		echo $apiRepo->answer();
	}
}
