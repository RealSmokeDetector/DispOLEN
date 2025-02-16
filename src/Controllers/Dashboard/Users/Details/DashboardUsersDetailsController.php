<?php

namespace App\Controllers\Dashboard\Users\Details;

use App\Configs\Path;
use App\Events\UpdateUserEvent;
use App\Factories\NavbarFactory;
use App\Models\Entities\Date;
use App\Models\Entities\User;
use App\Models\Repositories\DateRepository;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use App\Utils\System;

class DashboardUsersDetailsController {
	public function render() : void {
		UpdateUserEvent::implement();

		$user = UserRepository::getInformations(uid: $_GET["user"]);

		$dateRepo = new DateRepository(date: new Date(timestamp: strtotime(datetime: $user["date_create"])));

		if (
			!isset($_GET["user"])
			|| $_GET["user"] === ""
			|| $user === null
		) {
			System::redirect(url: "/dashboard/users");
		}

		$userRepo = new UserRepository(user: new User(uid : $_GET["user"]));
		$userGroup = UserRepository::getGroup(uid: $user["uid"]);
		$roles = UserRepository::getRoles(uid: $user["uid"]);
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
				"/scripts/users/edit.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/dashboard/users/details/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
