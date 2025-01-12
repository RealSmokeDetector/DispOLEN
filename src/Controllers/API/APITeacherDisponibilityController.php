<?php

namespace App\Controllers\API;

use App\Models\Entities\API;
use App\Models\Entities\Disponibility;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\DisponibilityRepository;

class APITeacherDisponibilityController {
	public function render() : void {
		header("Content-Type: application/json");

		switch ($_SERVER["REQUEST_METHOD"]) {
			case "POST":
				$json = file_get_contents("php://input");
				$body = json_decode($json);

				if (isset($body->uid_user) && isset($body->start_time) && isset($body->end_time)) {
					//create sql query that puts that in database???

					$data["message"] = "200";
					$data["description"] = "Disponibility successfully saved.";
				} else {
					http_response_code(400);

					$data["error"] = "Invalid request";
					$data["description"] = "Missing required fields.";
				}

				$api = new API($data);
				break;
			default:
				http_response_code(404);

				$data["error"] = "Not found";
				$data["description"] = "Unknown API call.";

				$api = new API($data);
				break;
		}

		$apiRepo = new APIRepository($api);
		echo $apiRepo->answer();
	}
}
