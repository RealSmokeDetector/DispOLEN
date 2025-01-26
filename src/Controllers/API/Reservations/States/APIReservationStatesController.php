<?php

namespace App\Controllers\API\Reservations\States;

use App\Models\Entities\API;
use App\Models\Entities\Reservation;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\ReservationRepository;

class APIReservationStatesController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch ($_SERVER["REQUEST_METHOD"]) {
			case "POST":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->reservation_uid) && isset($body->state)) {
					$reservationRepo = new ReservationRepository(reservation: new Reservation(uid: $body->reservation_uid));
					$reservationRepo->setState(state: $body->state);

					$data["message"] = "200";
					$data["description"] = "$body->reservation_uid's state successfully updated.";
				} else {
					http_response_code(response_code: 400);

					$data["error"] = "Invalid request";
					$data["description"] = "Unspecified UID.";
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
