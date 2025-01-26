<?php

namespace App\Controllers\API\Groups\Users;

use App\Models\Entities\API;
use App\Models\Entities\Group;
use App\Models\Repositories\APIRepository;
use App\Models\Repositories\GroupRepository;

class APIGroupsUsersController {
	public function render() : void {
		header(header: "Content-Type: application/json");

		switch ($_SERVER["REQUEST_METHOD"]) {
			case "PUT":
				$json = file_get_contents(filename: "php://input");
				$body = json_decode(json: $json);

				if (isset($body->group_uid) && isset($body->user_uid)) {
					$groupRepo = new GroupRepository(group: new Group(uid: $body->group_uid));

					if (!in_array(needle: $body->user_uid, haystack: $groupRepo->getUsers())) {
						$groupRepo->addUser(uid: $body->user_uid);

						$data["message"] = "200";
						$data["description"] = "User $body->user_uid successfully added to $body->group_uid.";
					} else {
						http_response_code(response_code: 400);

						$data["error"] = "User find";
						$data["description"] = "User $body->user_uid already in group $body->group_uid.";
					}
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

				if (isset($body->group_uid) && isset($body->user_uid)) {
					$groupRepo = new GroupRepository(group: new Group(uid: $body->group_uid));

					$groupRepo->removeUser(uid: $body->user_uid);

					$data["message"] = "200";
					$data["description"] = "User $body->user_uid successfully removed from $body->group_uid.";
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
