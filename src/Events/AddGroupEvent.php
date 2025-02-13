<?php

namespace App\Events;

use App\Models\Entities\Group;
use App\Models\Repositories\GroupRepository;
use App\Utils\System;
class AddGroupEvent {
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$groupRepo = new GroupRepository(group: new Group(name: $_POST["group_name"]));
			$groupRepo ->create();
			System::redirect();
		}
	}
}

?>
