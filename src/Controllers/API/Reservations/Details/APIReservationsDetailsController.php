<?php

namespace App\Controllers\API\Reservations\Details;

use App\Models\Entities\API;
use App\Models\Entities\Reservation;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\ReservationRepository;

class APIReservationsDetailsController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch($_SERVER["REQUEST_METHOD"]) {
			case "PUT":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (
					isset($body->uid_reservation)
					&& isset($body->id_type)
					&& isset($body->id_reason)
					&& isset($body->id_state)
					&& isset($body->comment)
				) {
					$reservationInfo = ReservationRepository::getInformation(uid: $body->uid_reservation);
					$reservationsRepo = new ReservationRepository(
						reservation: new Reservation(
							uid: $body->uid_reservation,
							typeId: $body->id_type,
							reasonId: $body->id_reason,
							stateId: $body->id_state,
							comment: $body->comment,
							date_start: $reservationInfo["date_start"],
							date_end: $reservationInfo["date_end"]
						)
					);

					$reservationsRepo->update();

					$data["message"] = "200";
					$data["description"] = "Reservation successufully updated.";
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
