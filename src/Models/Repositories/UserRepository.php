<?php

namespace App\Models\Repositories;

use App\Configs\Database;
use App\Models\Entities\User;
use App\Utils\ApplicationData;
use App\Utils\System;
use Exception;
use PDO;

class UserRepository {
	private $user;

	/**
	 * User construct
	 *
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * Create user
	 *
	 * @return Exception | string
	 */
	public function create() : Exception | string {
		$this->user->uid = System::uidGen(size: 16, table: Database::USERS);
		$this->user->password = password_hash(password: $this->user->password, algo: PASSWORD_BCRYPT);

		try {
			ApplicationData::request(
				query: "INSERT INTO " . Database::USERS . " (uid, name, surname, email, password) VALUES (:uid, :name, :surname, :email, :password)",
				data: [
					"uid" => $this->user->uid,
					"name" => $this->user->name,
					"surname" => $this->user->surname,
					"email" => $this->user->email,
					"password" => $this->user->password
				]
			);
		} catch (Exception $exception) {
			return $exception;
		}

		return $this->user->uid;
	}

	/**
	 * Update users
	 *
	 * @return void
	 */
	public function update() : void {
		ApplicationData::request(
			query: "UPDATE " . Database::USERS . " SET name = :name, surname = :surname WHERE uid = :uid",
			data: [
				"uid" => $this->user->uid,
				"name" => $this->user->name,
				"surname" => $this->user->surname
			]
		);
	}

	public function setPassword(): void{
		$this->user->password = password_hash(password: $this->user->password, algo: PASSWORD_BCRYPT);
		ApplicationData::request(
			query: "UPDATE " . Database::USERS . " SET password = :password WHERE uid = :uid",
			data: [
				"uid" => $this->user->uid,
				"password" => $this->user->password
			]
		);
	}

	/**
	 * Verify user password
	 *
	 * @return Exception | string
	 */
	public function verifyPassword() : Exception | string {
		$userData = ApplicationData::request(
			query: "SELECT uid, password FROM " . Database::USERS . " WHERE email = :email",
			data: [
				"email" => $this->user->email
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		if ($userData != null) {
			if (password_verify(password: $this->user->password, hash: $userData["password"])) {
				return $userData["uid"];
			} else {
				return new Exception(message: "Wrong password");
			}
		}

		return new Exception(message: "Unknown user");
	}

	/**
	 * Get student's tutor
	 *
	 * @return string
	 */
	public function getTutor() : mixed {
		return ApplicationData::request(
			query: "SELECT uid_teacher FROM " . Database::TUTORING . " WHERE uid_student = :uid_student",
			data: [
				"uid_student" => $this->user->uid
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Set student's tutor
	 *
	 * @param array $tutor
	 *
	 * @return void
	 */
	public function setTutor($tutor) : void {
		ApplicationData::request(
			query: "DELETE FROM " . Database::TUTORING . " WHERE uid_student = :uid",
			data: [
				"uid" => $this->user->uid
			]
		);

		ApplicationData::request(
			query: "INSERT INTO " .  Database::TUTORING . " (uid_student, uid_teacher) VALUES (:uid_student, :uid_teacher)",
			data: [
				"uid_student" => $this->user->uid,
				"uid_teacher" => $tutor
			]
		);
	}

	/**
	 * Get teacher's student
	 *
	 * @return array
	 */
	public function getTutoredStudent() : mixed {
		return ApplicationData::request(
			query: "SELECT uid_student FROM " . Database::TUTORING . " WHERE uid_teacher = :uid_teacher",
			data: [
				"uid_teacher" => $this->user->uid
			],
			returnType: PDO::FETCH_ASSOC
		);
	}

	/**
	 * Set tutor's sudent(s)
	 *
	 * @param array $tutoredStudents
	 *
	 * @return void
	 */
	public function setTutoredStudent($tutoredStudents) : void {
		ApplicationData::request(
			query: "DELETE FROM " . Database::TUTORING . " WHERE uid_teacher = :uid",
			data: [
				"uid" => $this->user->uid
			]
		);

		foreach ($tutoredStudents as $tutoredStudent) {
			ApplicationData::request(
				query: "INSERT INTO " . Database::TUTORING . " (uid_student, uid_teacher) VALUES (:uid_student, :uid_teacher)",
				data: [
					"uid_teacher" => $this->user->uid,
					"uid_student" => $tutoredStudent
				]
			);
		}
	}

	/**
	 * Get user's role(s)
	 *
	 * @param string $uid User's UID
	 *
	 * @return array
	 */
	public static function getRoles(string $uid) : array {
		return ApplicationData::request(
			query: "SELECT id_role FROM " . Database::USER_ROLE . " WHERE uid_user = :uid",
			data: [
				"uid" => $uid
			],
			returnType: PDO::FETCH_COLUMN
		);
	}

	/**
	 * Set user's role(s)
	 *
	 * @param array $roles
	 *
	 * @return void
	 */
	public function setRoles(array $roles) : void {
		ApplicationData::request(
			query: "DELETE FROM " . Database::USER_ROLE . " WHERE uid_user = :uid",
			data: [
				"uid" => $this->user->uid
			]
		);

		foreach ($roles as $role) {
			ApplicationData::request(
				query: "INSERT INTO " . Database::USER_ROLE . " (uid_user, id_role) VALUES (:uid_user, :id_role)",
				data: [
					"uid_user" => $this->user->uid,
					"id_role" => $role
				]
			);
		}
	}

	/**
	 * Get user's group
	 *
	 * @param string $uid User's UID
	 *
	 * @return mixed
	 */
	public static function getGroup($uid) : mixed{
		return ApplicationData::request(
			query: "SELECT uid_group FROM " . Database::USER_GROUP . " WHERE uid_user = :uid",
			data: [
				"uid" => $uid
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get user's informations
	 *
	 * @return null | array
	 */
	public static function getInformations($uid) : null | array {
		return ApplicationData::request(
			query: "SELECT * FROM " . Database::USERS . " WHERE uid = :uid",
			data: [
				"uid" => $uid
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);
	}

	/**
	 * Get teacher disponibilities
	 *
	 * @param string $uid
	 *
	 * @return array
	 */
	public static function getTeacherDisponibilities(string $uid) : array {
		return ApplicationData::request(
			query: "SELECT * FROM " . Database::DISPONIBILITIES . " WHERE uid_user = :uid",
			data: [
				"uid" => $uid,
			],
			returnType: PDO::FETCH_ASSOC
		);
	}
}
