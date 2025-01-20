<?php

namespace App\Controllers\Calendar;

use App\Configs\Path;
use App\Factories\NavbarFactory;

class CalendarController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		require Path::LAYOUT . "/header.php";

		new NavbarFactory();

		require Path::LAYOUT . "/calendar/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
