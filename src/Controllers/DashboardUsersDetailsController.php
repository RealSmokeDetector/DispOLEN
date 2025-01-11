<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;

class DashboardUsersDetailsController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		$userId = $_GET["user"];

		$user = UserRepository::getInformations(uid: $userId);
		$userEntity = new User(uid : $userId) ;
		$userRepo = new UserRepository(user: $userEntity);
		$userGroup = UserRepository::getGroup(uid: $user["uid"]);
		$roles = UserRepository::getRoles(uid: $user["uid"]);

		$rolesName = [];
		foreach ($roles as $role) {
			array_push($rolesName, ApplicationData::roleFormat(id: $role));
		}

		$tutoredStudents = [];
		foreach ($userRepo->getTutoredStudent() as $student) {
			$studentInfo = UserRepository::getInformations(uid: $student["uid_student"]);
			array_push($tutoredStudents, $studentInfo["name"]);
		}

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/dashboard/users/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
