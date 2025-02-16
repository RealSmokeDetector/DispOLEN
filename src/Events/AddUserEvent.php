<?php

namespace App\Events;

use App\Models\Entities\Mail;
use App\Models\Entities\User;
use App\Models\Repositories\MailRepository;
use App\Models\Repositories\UserRepository;
use App\Utils\Lang;
use App\Utils\System;

class AddUserEvent {
	public static function implement() : void {
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			if (
				isset($_POST["name"])
				&& isset($_POST["surname"])
				&& isset($_POST["email"])
			) {
				$password = System::uidGen(size: 6);

				$userRepo = new UserRepository(user: new User(name: $_POST["name"], surname: $_POST["surname"], email: $_POST["email"], password: $password, toModify: true));
				$userRepo->create();

				$email = new MailRepository(mail: new Mail(receiver: $_POST["email"], body: Lang::translate(key: "EMAIL_CREATE_USER_BODY", options: ["name" => APP_NAME, "password" => $password]), object: Lang::translate(key: "EMAIL_CREATE_USER_OBJECT", options: ["name" => APP_NAME])));
				$email->send();
			}
		}
	}
}
