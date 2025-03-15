<?php

namespace App\Controllers\Groups;

use App\Configs\Path;
use App\Configs\Role;
use App\Events\AddGroupEvent;
use App\Factories\NavbarFactory;
use App\Models\Entities\Group;
use App\Models\Repositories\GroupRepository;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use App\Utils\Roles;

class GroupsController {
	public function render() : void {
		AddGroupEvent::implement();

		$groups = ApplicationData::getGroups();
		$roles = UserRepository::getRoles(uid: $_SESSION["user"]["uid"]);

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
			"/scripts/group.js",
			"/scripts/groups/popup.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		if (Roles::check(userRoles: $roles, allowRoles: [Role::ADMINISTRATOR])) {
			include Path::COMPONENTS . "/popup/group_add_popup.php";
		}

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/groups/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
