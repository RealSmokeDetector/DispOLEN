<?php

namespace App\Controllers\Accounts;

use App\Configs\Path;
use App\Events\LoginEvent;
use App\Factories\NavbarFactory;

class LoginController {
	public function render() : void {
		LoginEvent::implement();

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
			"https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.4.0/tsparticles.confetti.bundle.min.js"
		];

		require Path::LAYOUT . "/header.php";

		(new NavbarFactory())->render();

		require Path::LAYOUT . "/login/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
