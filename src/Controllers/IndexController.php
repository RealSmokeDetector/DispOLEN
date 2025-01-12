<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Utils\System;
use App\Configs\Role;
use App\Models\Repositories\UserRepository;

class IndexController {
	public function render() : void {
		if (!isset($_SESSION["user"])) {
			System::redirect(url: "/login");
		}

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/calendar.js",
      "/scripts/display_timeslots.js"
		];

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		if (!empty(array_intersect(UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), [Role::STUDENT]))) {
			require Path::LAYOUT . "/index/student.php";
		}
		else {
			require Path::LAYOUT . "/index/teacher.php";
		}

		include Path::LAYOUT . "/footer.php";
	}
}
