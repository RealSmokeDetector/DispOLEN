<?php

namespace App\Controllers\API\Groups;

use App\Models\Entities\API;
use App\Models\Entities\Group;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\GroupRepository;

class APIGroupsController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch ($_SERVER["REQUEST_METHOD"]) {
			case "POST":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->group_uid) && isset($body->name)) {
					$groupRepo = new GroupRepository(group: new Group(uid: $body->group_uid));

					$groupRepo->setName(name: $body->name);

					$data["message"] = "200";
					$data["description"] = "$body->group_uid's named successfully updated.";
				} else {
					http_response_code(response_code: 400);

					$data["error"] = "Invalid request";
					$data["description"] = "Unspecified UID.";
				}

				$api = new API(data: $data);
				break;
			case "DELETE":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->group_uid)) {
					$groupRepo = new GroupRepository(group: new Group(uid: $body->group_uid));

					$groupRepo->remove();

					$data["message"] = "200";
					$data["description"] = "$body->group_uid successufully removed.";
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
