<?php

namespace App\Controllers\Accounts;

use App\Configs\Path;
use App\Events\AccountEvent;
use App\Factories\NavbarFactory;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;

class AccountIndexController {
	public function render() : void {
		AccountEvent::implement();

		$userInfo = UserRepository::getInformations(uid: $_SESSION["user"]["uid"]);
		$userRepo = new UserRepository(user: new User(uid: $_SESSION["user"]["uid"]));
		$userInfo = UserRepository::getInformations(uid: $_SESSION["user"]["uid"]);
		$userGroup = UserRepository::getGroup(uid: $userInfo["uid"]);
		$roles = UserRepository::getRoles(uid: $userInfo["uid"]);
		$teachers = ApplicationData::getAllTeachers();
		$students = ApplicationData::getAllStudents();

		$rolesName = [];
		foreach ($roles as $role) {
			array_push($rolesName, ApplicationData::roleFormat(id: $role));
		}

		$tutoredStudents = [];
		foreach ($userRepo->getTutoredStudent() as $student) {
			$studentInfo = UserRepository::getInformations(uid: $student["uid_student"]);

			array_push($tutoredStudents, htmlspecialchars(string: ucfirst(string: $studentInfo["surname"]) . " " . ucfirst(string: $studentInfo["name"])));
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/account/edit.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/account/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
