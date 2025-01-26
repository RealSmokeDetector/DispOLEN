<?php

namespace App\Dev\Gens;

use App\Configs\Database;
use App\Configs\Role;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Utils\ApplicationData;
use PDO;

class RolesGenerator {
	public function __construct(int $amountTutor = 0, int $amountAdministrator = 0) {
		$usersUid = ApplicationData::request(
			query: "SELECT uid_user FROM " . Database::USER_ROLE . " ORDER BY random() LIMIT :amount",
			data: [
				"amount" => $amountTutor + $amountAdministrator,
			],
			returnType: PDO::FETCH_ASSOC
		);

		for ($i = 0; $i < $amountAdministrator; $i++) {
			$userRepo = new UserRepository(user: new User(uid: $usersUid[$i]["uid_user"]));

			$userRepo->setRoles(roles: [Role::ADMINISTRATOR]);
		}

		for ($i = $amountAdministrator; $i < $amountAdministrator + $amountTutor; $i++) {
			$userRepo = new UserRepository(user: new User(uid: $usersUid[$i]["uid_user"]));

			$userRepo->setRoles(roles: [Role::TEACHER]);
		}
	}
}
