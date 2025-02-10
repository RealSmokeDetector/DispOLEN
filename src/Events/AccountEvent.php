<?php

namespace App\Events;

use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\Lang;
use App\Utils\System;

class AccountEvent {
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			if (
				isset($_POST["password"])
				&& isset($_POST["password_confirm"])
			) {
				if ($_POST["password"] === $_POST["password_confirm"]) {
					$userRepo = new UserRepository(user: new User(uid: $_SESSION["user"]["uid"], password: $_POST["password"]));
					$userRepo->setPassword();

					System::redirect(url: "/disconnect");
				} else {
					setcookie("NOTIFICATION", Lang::translate(key: "REGISTER_UNIDENTICAL_PASSWORD"), time() + 60*60*24*30);
				}
			}
		}
	}
}
