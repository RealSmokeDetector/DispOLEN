<?php

namespace App\Controllers;

use App\Utils\System;

class DashboardController {
	public function render() : void {
		System::redirect(url: "/");
	}
}
