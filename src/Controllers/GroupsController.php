<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Models\Entities\Group;
use App\Models\Repositories\GroupRepository;
use App\Utils\ApplicationData;
use App\Utils\System;

class GroupsController {
	public function render() : void {
		$groups = ApplicationData::getGroups();

		if (count(value: $groups) > 0) {
			isset($_GET["group"]) ? $selectedGroup = $_GET["group"] : $selectedGroup = $groups[0];

			if (!in_array(needle: $selectedGroup, haystack: $groups) || $selectedGroup === "") {
				$selectedGroup = $groups[0];
			}

			foreach ($groups as $key => $value) {
				$group = new Group(uid: $value);
				$groupRepo = new GroupRepository(group: $group);

				$groups[$key] = [
					"uid" => $value,
					"name" => $groupRepo->getInformations()["name"],
					"users" => $groupRepo->getUsers()
				];
			}
		}

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/groups/index.php";

		System::implementScripts(scripts: ["/scripts/engine.js", "/scripts/theme.js", "/scripts/group.js"]);

		include Path::LAYOUT . "/footer.php";
	}
}
