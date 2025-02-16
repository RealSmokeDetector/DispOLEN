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

		$tutoredStudents = $userRepo->getTutoredStudent();
		$tutoredStudentsName = [];
		foreach ($tutoredStudents as $student) {
			$studentInfo = UserRepository::getInformations(uid: $student);
			array_push($tutoredStudentsName, htmlspecialchars(string: ApplicationData::nameFormat(name: $studentInfo["name"], surname: $studentInfo["surname"])));
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/account/edit.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/account/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
