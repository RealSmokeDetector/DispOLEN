<?php

namespace App\Controllers\API\Disponibilities;

use App\Models\Entities\API;
use App\Models\Entities\Date;
use App\Models\Entities\Disponibility;
use App\Models\Entities\User;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\DisponibilityRepository;

class APIDisponibilitiesController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch($_SERVER["REQUEST_METHOD"]) {
			case "GET":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->uid) && isset($body->date_start)) {
					$disponibilityRepo = new DisponibilityRepository(disponibility: new Disponibility(user: new User(uid: $body->uid)));

					$result = $disponibilityRepo->getDisponibilities( date: new DateRepository(date: new Date(timestamp: strtotime(datetime: $body->date_start))));

					if ($result != null) {
						$data = $result;
					} else {
						http_response_code(response_code: 200);

						$data["error"] = "Not found";
						$data["description"] = "No Disponibility found.";
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
