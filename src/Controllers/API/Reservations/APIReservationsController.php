<?php

namespace App\Controllers\API\Reservations;

use App\Configs\Database;
use App\Models\Entities\API;
use App\Models\Entities\User;
use App\Models\Entities\Reservation;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\ReservationRepository;
use App\Utils\ApplicationData;
use App\Utils\Date;
use App\Utils\System;

class APIReservationsController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch($_SERVER["REQUEST_METHOD"]) {
			case "POST":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->uid) && isset($body->date_start)) {
					$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $body->uid)));
					$dateGiven = new Date(date: $body->date_start);

					$data = $reservationRepo->reservationByDate(dateStart: $dateGiven);
				} else {
					http_response_code(response_code: 400);

					$data["error"] = "Invalid request";
					$data["description"] = "Unspecified date.";
				}
				$api = new API(data: $data);
				break;
			case "PUT":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->uid_user) && isset($body->date_start) && isset($body->date_end)) {
					$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $body->uid_user), date_start: $body->date_start, date_end: $body->date_end));
					$reservationRepo->addDisponibility();

					$data["message"] = "200";
					$data["description"] = "Disponibility added successufully.";
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
