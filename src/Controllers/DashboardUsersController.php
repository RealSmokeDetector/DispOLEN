<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Utils\System;

class DashboardUsersController {
	public function render() : void {
		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/navbar.php";

		require Path::LAYOUT . "/dashboard/users/index.php";

		System::implementScripts(scripts: ["/scripts/engine.js", "/scripts/theme.js"]);

		include Path::LAYOUT . "/footer.php";
	}
}
