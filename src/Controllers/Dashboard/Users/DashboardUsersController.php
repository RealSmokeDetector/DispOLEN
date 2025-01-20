<?php

namespace App\Controllers\Dashboard\Users;

use App\Configs\Path;
use App\Factories\NavbarFactory;

class DashboardUsersController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		require Path::LAYOUT . "/header.php";

		new NavbarFactory();

		require Path::LAYOUT . "/dashboard/users/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
