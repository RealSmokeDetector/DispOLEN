<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use App\Utils\System;

class DashboardUsersDetailsController {
	public function render() : void {
		$userId = $_GET["user"];

		$user = UserRepository::getInformations(uid: $userId);
		$userEntity = new User(uid : $userId) ;
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
			$studentInfo = UserRepository::getInformations(uid: $student['uid_student']);
			array_push($tutoredStudents, $studentInfo['name']);
		}

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/dashboard/users/details/index.php";

		System::implementScripts(
			scripts: [
				"/scripts/engine.js",
				"/scripts/theme.js",
				"/scripts/user/edit.js"
			]
		);

		include Path::LAYOUT . "/footer.php";
	}
}
