<?php

namespace App\Controllers\Dashboard;

use App\Utils\System;

class DashboardController {
	public function render() : void {
		System::redirect(url: "/");
	}
}
