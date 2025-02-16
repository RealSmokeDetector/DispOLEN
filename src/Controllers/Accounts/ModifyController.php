<?php

namespace App\Controllers\Accounts;

use App\Configs\Path;
use App\Events\ModifyEvent;

class ModifyController {
	public function render() : void {
		ModifyEvent::implement();

		$scripts = [
			"/scripts/engine.js",
			"/scripts/theme.js",
		];

		require Path::LAYOUT . "/header.php";

		require Path::LAYOUT . "/modify/index.php";

		include Path::LAYOUT . "/footer.php";
	}
}
