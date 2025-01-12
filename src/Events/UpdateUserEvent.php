<?php

namespace App\Events;

use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;

class UpdateUserEvent{
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$user = new User(uid: $_POST["uid"], name: $_POST["name"], surname: $_POST["surname"]);
			$userRepo = new UserRepository(user: $user);
			$userRepo->update();
			$userRepo->setRoles(roles: $_POST["roles"]);

			if (isset($_POST["tutor"])) {
				$userRepo->setTutor(tutor: $_POST["tutor"]);
			}

			if (isset($_POST["tutoredStudents"])) {
				$userRepo->setTutoredStudent(tutoredStudents: $_POST["tutoredStudents"]);
			}
		}
	}
}
