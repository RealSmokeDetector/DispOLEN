<?php

namespace App\Controllers\API\Dates\Offdays;

use App\Models\Entities\API;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\DateRepository;

class APIDateOffdaysController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch ($_SERVER["REQUEST_METHOD"]) {
			case "POST":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->year)) {
					$data = DateRepository::getOffDays(year: $body->year);
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
