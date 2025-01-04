<?php

namespace App\Models\Repositories;

use App\Models\Entities\Group;
use App\Utils\ApplicationData;
use App\Utils\System;
use Exception;
use PDO;
use App\Configs\Database;

class GroupRepository {
	private $group;

	/**
	 * Group construct
	 *
	 * @param Group $group
	 */
	public function __construct(Group $group) {
		$this->group = $group;
	}

	/**
	 * Create group
	 *
	 * @return Exception | string
	 */
	public function create() : Exception | string {
		$this->group->uid = System::uidGen(size: 16, table: Database::GROUPS);

		ApplicationData::request(
			query: "INSERT INTO " . Database::GROUPS . " (uid, name) VALUES (:uid,:name)",
			data: [
				"uid" => $this->group->uid,
				"name" => $this->group->name,
			]
		);

		return $this->group->uid;
	}

	/**
	 * Get informations
	 *
	 * @return Exception | array
	 */
	public function getInformations() : Exception | array {
		$groupData = ApplicationData::request(
			query: "SELECT * FROM " . Database::GROUPS . " WHERE uid = :uid",
			data: [
				"uid" => $this->group->uid
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		if (empty($groupData)) {
			throw new Exception("Group not found");
		}

		return $groupData;
	}

	/**
	 * Get users by group
	 *
	 * @return Exception | array
	 */
	public function getUsers() : Exception | array {
		$users = ApplicationData::request(
			query: "SELECT u.* FROM " . Database::USERS . " u
					JOIN user_group ug ON u.uid = ug.uid_user
					WHERE ug.uid_group = :uid_group",
			data: [
				"uid_group" =>$this->group->uid
			],
			returnType: PDO::FETCH_ASSOC
		);

		if (empty($users)) {
			return new Exception("Users not found");
		}

		return $users;
	}
}
