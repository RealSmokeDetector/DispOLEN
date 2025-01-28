<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Factories\NavbarFactory;
use App\Models\Entities\User;
use App\Utils\Roles;
use App\Utils\System;
use App\Configs\Role;
use App\Models\Repositories\UserRepository;
use App\Utils\Date;

class IndexController {
	public function render() : void {
		if (!isset($_SESSION["user"])) {
			System::redirect(url: "/login");
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/times/calendar.js",
			"/scripts/times/timeslots.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		if (Roles::check(userRoles: UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), allowRoles: [Role::STUDENT])) {
			$userRepo = new UserRepository(user: new User(uid: $_SESSION["user"]["uid"]));
			$teacherUid = $userRepo->getTutor();

			if ($teacherUid != null) {
				$teacherDisponibilities = UserRepository::getTeacherDisponibilities(uid: $teacherUid);
			}
		}
		define(constant_name: "HEIGHT_TIMESLOTS_DIV", value: 306);

		$date = new Date();

		require Path::LAYOUT . "/index/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
