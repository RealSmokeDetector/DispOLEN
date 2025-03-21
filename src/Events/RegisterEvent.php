<?php

namespace App\Events;

use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\Lang;
use App\Utils\System;
use Exception;

class RegisterEvent {
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			if (
				isset($_POST["name"])
				&& isset($_POST["surname"])
				&& isset($_POST["email"])
				&& isset($_POST["password"])
				&& isset($_POST["password_confirm"])
			) {
				if (!filter_var(value: $_POST["email"], filter: FILTER_VALIDATE_EMAIL)) {
					setcookie("NOTIFICATION", Lang::translate(key: "REGISTER_INVALID_EMAIL", options: ["email" => htmlspecialchars(string: $_POST["email"])]), time() + 60*60*24*30);
				} else {
					if ($_POST["password"] === $_POST["password_confirm"]) {
						$userRepo = new UserRepository(user: new User(name: $_POST["name"], surname: $_POST["surname"], email: $_POST["email"], password: $_POST["password"]));
						$uid = $userRepo->create();

						if ($uid instanceof Exception) {
							setcookie("NOTIFICATION", Lang::translate(key: "REGISTER_ALREADY_EXIST", options: ["email" => htmlspecialchars(string: $_POST["email"])]), time() + 60*60*24*30);
						} else {
							$_SESSION["user"]["uid"] = $uid;
							System::redirect(url: "/");
						}
					} else {
						setcookie("NOTIFICATION", Lang::translate(key: "REGISTER_UNIDENTICAL_PASSWORD"), time() + 60*60*24*30);
					}
				}
			}
		}
	}
}
