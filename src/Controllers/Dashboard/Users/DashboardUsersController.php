<?php

namespace App\Controllers\Dashboard\Users;

use App\Configs\Path;
use App\Events\AddUserEvent;
use App\Factories\NavbarFactory;

class DashboardUsersController {
	public function render() : void {
		AddUserEvent::implement();

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"/scripts/users/popup.js",
			"/scripts/users/search.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		require Path::COMPONENTS . "/popup/user_add_popup.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/dashboard/users/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
