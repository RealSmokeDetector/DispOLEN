<?php

namespace App\Controllers\Groups;

use App\Configs\Path;
use App\Factories\NavbarFactory;
use App\Models\Entities\Group;
use App\Models\Repositories\GroupRepository;
use App\Utils\ApplicationData;

class GroupsController {
	public function render() : void {
		$groups = ApplicationData::getGroups();

		if (count(value: $groups) > 0) {
			isset($_GET["group"]) ? $selectedGroup = $_GET["group"] : $selectedGroup = $groups[0];

			if (!in_array(needle: $selectedGroup, haystack: $groups) || $selectedGroup === "") {
				$selectedGroup = $groups[0];
			}

			foreach ($groups as $key => $value) {
				$groupRepo = new GroupRepository(group: new Group(uid: $value));

				$groups[$key] = [
					"uid" => $value,
					"name" => $groupRepo->getInformations()["name"],
					"users" => $groupRepo->getUsers()
				];
			}
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/group.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/groups/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
