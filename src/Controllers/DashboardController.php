<?php

namespace App\Controllers;

use App\Configs\Path;
use App\Utils\System;

class DashboardController {
	public function render() : void {
		System::redirect(url: "/");
	}
}
