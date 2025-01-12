<?php

namespace App\Utils;

use App\Configs\Database;
use App\Configs\Role;
use PDO;

class ApplicationData {

	/**
	 * Database request
	 *
	 * @param string $query SQL query
	 * @param array $data Data to bind
	 * @param int $returnType Specified type to get return value
	 * @param bool $singleValue Does the return type should be a single value
	 *
	 * @return mixed
	 */
	public static function request(string $query, array $data = null, int $returnType = null, bool $singleValue = false) : mixed {
		$stmt = DATABASE->prepare(query: $query);

		if ($data) {
			foreach (array_keys($data) as $key) {
				$stmt->bindParam(
					param: $key,
					var: $data[$key]
				);
			}
		}

		$stmt->execute();

		if ($returnType) {
			return $singleValue ? $stmt->fetchAll($returnType)[0] ?? null : $stmt->fetchAll($returnType) ?? null;
		}

		return 0;
	}

	/**
	 * Return every users uid
	 *
	 * @return array
	 */
	public static function getUsers() : array {
		return ApplicationData::request(
			query: "SELECT * FROM " . Database::USERS,
			returnType: PDO::FETCH_ASSOC
		);
	}

	/**
	 * Get state's name
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public static function getStateName(int $id) : string {
		return ApplicationData::request(
			query: "SELECT name FROM " . Database::STATES . " WHERE id = :id",
			data: [
				"id" => $id
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get reason's name
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public static function getReasonName(int $id) : string {
		return ApplicationData::request(
			query: "SELECT name FROM " . Database::REASONS . " WHERE id = :id",
			data: [
				"id" => $id
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get type's name
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public static function getTypeName(int $id) : string {
		return ApplicationData::request(
			query: "SELECT name FROM " . Database::TYPES . " WHERE id = :id",
			data: [
				"id" => $id
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Format role name
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public static function roleFormat(int $id) : string {
		switch ($id) {
			case Role::STUDENT:
				return Lang::translate(key: "MAIN_STUDENT");
			case Role::TEACHER:
				return Lang::translate(key: "MAIN_TEACHER");
			case Role::ADMINISTRATOR:
				return Lang::translate(key: "MAIN_ADMINISTRATOR");
			default:
				return "";
		}
	}

	public static function getGroups() : array {
		return ApplicationData::request(
			query: "SELECT uid FROM " . Database::GROUPS . " ORDER BY name",
			returnType: PDO::FETCH_COLUMN
		);
	}

	/**
	 * Get group's name
	 *
	 * @param string $uid
	 *
	 * @return string
	 */
	public static function getGroupName(string $uid) : string {
		return ApplicationData::request(
			query: "SELECT name FROM " . Database::GROUPS . " WHERE uid = :uid",
			data: [
				"uid" => $uid
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Format names
	 *
	 * @param string $name
	 * @param string $surname
	 * @param bool $complete Name and surname complete
	 * @param int $toChange 1 for name, 2 for surname
	 * @param bool $reverse Reverse name and surname
	 *
	 * @return string
	 */
	public static function nameFormat(string $name, string $surname, bool $complete = true, int $toChange = null, bool $reverse = false) : string {
		if (!$complete) {
			if ($toChange === 1) {
				$name = mb_substr(string: $name, start: 0, length: 1) . ".";
			} else {
				$surname = mb_substr(string: $surname, start: 0, length: 1) . ".";
			}
		}

		$name = ucfirst(string: mb_strtolower(string: $name));
		$surname = ucfirst(string: mb_strtolower(string: $surname));

		if ($reverse) {
			return $surname . " " . $name;
		}

		return $name . " " . $surname;
	}

	/**
	 * Get roles
	 *
	 * @return array
	 */
	public static function getRoles() : array {
		return ApplicationData::request(
			query: "SELECT id FROM " . Database::ROLES,
			returnType: PDO::FETCH_COLUMN
		);
	}

	/**
	 * Get all teachers
	 *
	 * @return array
	 */
	public static function getAllTeachers() : array {
		return ApplicationData::request(
			query: "SELECT uid FROM " . Database::USERS . " JOIN " . Database::USER_ROLE . " ON " . Database::USERS . ".uid = " . Database::USER_ROLE . ".uid_user WHERE " . Database::USER_ROLE . ".id_role = 2 ",
			returnType: PDO::FETCH_COLUMN
		);
	}

	/**
	 * Get all students
	 *
	 * @return array
	 */
	public static function getAllStudents() : array {
		return ApplicationData::request(
			query: "SELECT uid FROM " . Database::USERS . " JOIN " . Database::USER_ROLE . " ON " . Database::USERS . ".uid = " . Database::USER_ROLE . ".uid_user WHERE " . Database::USER_ROLE . ".id_role = 1 ",
			returnType: PDO::FETCH_COLUMN
		);
	}
}
