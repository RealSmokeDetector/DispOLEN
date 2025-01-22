<?php

namespace App\Dev\Gens;

use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use Faker\Factory;

class UsersGenerator {
	private $emailProvider = [
		"gmail.com",
		"hotmail.com",
		"yahoo.com",
		"outlook.com",
		"icloud.com",
	];

	public function __construct(int $amount = 1) {
		$faker = Factory::create(locale: "fr_FR");

		for ($i = 0; $i < $amount; $i++) {
			$names = explode(separator: " ", string: $faker->name());
			$name = $names[0];
			$surname = $names[1];

			$email = mb_strtolower(string: iconv(from_encoding: 'UTF-8', to_encoding: 'ASCII//TRANSLIT',  string: $name . "." . $surname)) . "@" . $this->emailProvider[array_rand(array: $this->emailProvider)];

			$user = new User(name: $name, surname: $surname, email: $email, password: mb_strtolower(string: iconv(from_encoding: 'UTF-8', to_encoding: 'ASCII//TRANSLIT', string: $name)));
			$userRepo = new UserRepository(user: $user);

			$userRepo->create();
		}
	}
}
