<?php

namespace App\Controllers\Accounts;

use App\Configs\Path;
use App\Factories\NavbarFactory;

class AccountIndexController {
	public function render() : void {
		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js"
		];

		require Path::LAYOUT . "/header.php";

		new NavbarFactory();

		require Path::LAYOUT . "/account/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
