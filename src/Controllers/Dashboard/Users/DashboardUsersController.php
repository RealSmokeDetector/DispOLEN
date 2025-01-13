<?php

namespace App\Controllers\Dashboard\Users;

use App\Configs\Path;

class DashboardUsersController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/dashboard/users/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
