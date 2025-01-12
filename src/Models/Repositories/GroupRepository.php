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
	 * Remove group
	 *
	 * @return void
	 */
	public function remove() : void {
		foreach ($this->getUsers() as $user) {
			$this->removeUser(uid: $user);
		}

		ApplicationData::request(
			query: "DELETE FROM " . Database::GROUPS . " WHERE uid = :uid",
			data: [
				"uid" => $this->group->uid
			]
		);
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
			throw new Exception(message: "Group not found");
		}

		return $groupData;
	}

	/**
	 * Get group's users
	 *
	 * @return null | array
	 */
	public function getUsers() : null | array {
		return ApplicationData::request(
			query: "SELECT uid_user FROM " . Database::USER_GROUP . " WHERE uid_group = :uid_group",
			data: [
				"uid_group" =>$this->group->uid
			],
			returnType: PDO::FETCH_COLUMN
		);
	}

	/**
	 * Add user
	 *
	 * @param string $uid
	 *
	 * @return void
	 */
	public function addUser(string $uid) : void {
		ApplicationData::request(
			query: "INSERT INTO " . Database::USER_GROUP . " (uid_user, uid_group) VALUES (:uid_user, :uid_group)",
			data: [
				"uid_user" => $uid,
				"uid_group" => $this->group->uid
			]
		);
	}

	/**
	 * Remove user
	 *
	 * @param string $uid
	 *
	 * @return void
	 */
	public function removeUser(string $uid) : void {
		ApplicationData::request(
			query: "DELETE FROM " . Database::USER_GROUP . " WHERE uid_user = :uid_user AND uid_group = :uid_group",
			data: [
				"uid_user" => $uid,
				"uid_group" => $this->group->uid
			]
		);
	}

	/**
	 * Update group name
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function setName(string $name) : void {
		$this->group->name = $name;

		ApplicationData::request(
			query: "UPDATE " . Database::GROUPS . " SET name = :name WHERE uid = :uid",
			data: [
				"uid" => $this->group->uid,
				"name" => $this->group->name
			]
		);
	}
}
