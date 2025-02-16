<?php

namespace App\Controllers\API\Reservations;

use App\Models\Entities\API;
use App\Models\Entities\Date;
use App\Models\Entities\Disponibility;
use App\Models\Entities\User;
use App\Models\Entities\Reservation;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\DisponibilityRepository;
use App\Models\Repositories\ReservationRepository;

class APIReservationsController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch($_SERVER["REQUEST_METHOD"]) {
			case "POST":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if(isset($body->date_end)){
					if (isset($body->uid) && isset($body->date_start) && isset($body->date_end)) {
						$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $body->uid)));

						$result = $reservationRepo->reservationByDate(dateRepo: new DateRepository(date: new Date(timestamp: strtotime(datetime: $body->date_start))));

						if ($result != null) {
							$data = $result;
						} else {
							http_response_code(response_code: 200);

							$data["error"] = "Not found";
							$data["description"] = "No reservations found.";
						}
					} else {
						http_response_code(response_code: 400);

						$data["error"] = "Invalid request";
						$data["description"] = "Unspecified date.";
					}
				} else {
					if (isset($body->uid) && isset($body->date_start)) {
						$reservationRepo = new ReservationRepository(reservation: new Reservation(user: new User(uid: $body->uid)));

						$result = $reservationRepo->reservationByDate(dateRepo: new DateRepository(date: new Date(timestamp: strtotime(datetime: $body->date_start))));

						if ($result != null) {
							$data = $result;
						} else {
							http_response_code(response_code: 200);

							$data["error"] = "Not found";
							$data["description"] = "No reservations found.";
						}
					} else {
						http_response_code(response_code: 400);

						$data["error"] = "Invalid request";
						$data["description"] = "Unspecified date.";
					}
				}
				$api = new API(data: $data);
				break;
			case "PUT":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->uid_user) && isset($body->date_start) && isset($body->date_end)) {
					$reservationRepo = new DisponibilityRepository(disponibility: new Disponibility(user: new User(uid: $body->uid_user), startDate: $body->date_start, endDate: $body->date_end));
					$reservationRepo->create();

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
