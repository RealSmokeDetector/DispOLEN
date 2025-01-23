<?php

namespace App\Controllers\Dashboard\Users\Details;

use App\Configs\Path;
use App\Events\UpdateUserEvent;
use App\Factories\NavbarFactory;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use App\Utils\System;

class DashboardUsersDetailsController {
	public function render() : void {
		UpdateUserEvent::implement();

		$user = UserRepository::getInformations(uid: $_GET["user"]);

		if (
			!isset($_GET["user"])
			|| $_GET["user"] === ""
			|| $user === null
		) {
			System::redirect(url: "/dashboard/users");
		}

		$userEntity = new User(uid : $_GET["user"]) ;
		$userRepo = new UserRepository(user: $userEntity);
		$userGroup = UserRepository::getGroup(uid: $user["uid"]);
		$roles = UserRepository::getRoles(uid: $user["uid"]);
		$teachers = ApplicationData::getAllTeachers();
		$students = ApplicationData::getAllStudents();

		$rolesName = [];
		foreach ($roles as $role) {
			array_push($rolesName, ApplicationData::roleFormat(id: $role));
		}

		$tutoredStudents = [];
		foreach ($userRepo->getTutoredStudent() as $student) {
			$studentInfo = UserRepository::getInformations(uid: $student["uid_student"]);
			array_push($tutoredStudents, $studentInfo["name"]);
		}

		$scripts = [
				"/scripts/engine.js",
				"/scripts/theme.js",
				"/scripts/users/edit.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/dashboard/users/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
