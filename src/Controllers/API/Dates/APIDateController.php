<?php

namespace App\Controllers\API\Dates;

use App\Models\Entities\API;
use App\Models\Repositories\APIRepository;

class APIDateController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch ($_SERVER["REQUEST_METHOD"]) {
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
