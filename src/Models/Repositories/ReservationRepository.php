<?php

namespace App\Models\Repositories;

use App\Configs\Database;
use App\Configs\Role;
use App\Models\Entities\Reservation;
use App\Utils\ApplicationData;
use App\Utils\System;
use PDO;

class ReservationRepository {
	private $reservation;

	/**
	 * Reservation construct
	 *
	 * @param Reservation $reservation
	 */
	public function __construct(Reservation $reservation) {
		$this->reservation = $reservation;
	}

	/**
	 * Create reservation
	 *
	 * @return void
	 */
	public function create() : void {
		$this->reservation->uid = System::uidGen(size: 16, table: Database::USERS);

		ApplicationData::request(
			query: "INSERT INTO " . Database::RESERVATIONS . "(uid, uid_teacher, uid_student, uid_disponibilities, id_type, id_reason, id_state, comment) VALUES (:uid, :uid_teacher, :uid_student, :uid_disponibilities, :id_type, :id_reason, :id_state, :comment)",
			data: [
				"uid" => $this->reservation->uid,
				"uid_teacher" => $this->reservation->teacherUid,
				"uid_student" => $this->reservation->studentUid,
				"uid_disponibilities" => $this->reservation->disponibilitiesUid,
				"id_type" => $this->reservation->typeId,
				"id_reason" => $this->reservation->reasonId,
				"id_state" => $this->reservation->stateId,
				"comment" => $this->reservation->comment
			]
		);
	}

	/**
	 * Update reservation
	 *
	 * @return void
	 */
	public function update() : void {
		ApplicationData::request(
			query: "UPDATE " . Database::RESERVATIONS . " SET id_type = :id_type, id_reason = :id_reason, id_state = :id_state, comment = :comment WHERE uid = :uid",
			data: [
				"uid" => $this->reservation->uid,
				"id_type" => $this->reservation->typeId,
				"id_reason" => $this->reservation->reasonId,
				"id_state" => $this->reservation->stateId,
				"comment" => $this->reservation->comment
			]
		);
	}

	/**
	 * Get information
	 *
	 * @return null | array
	 */
	public function getInformation() : null | array {
		$reservationData = ApplicationData::request(
			query: "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid = :uid",
			data: [
				"uid" => $this->reservation->uid,
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		return $reservationData;
	}

	/**
	 * Get all reservations
	 *
	 * @return array
	 */
	public function getReservations() : array {
		$roleUser = UserRepository::getRoles(uid: $this->reservation->user->uid);

		if (!empty(array_intersect($roleUser, [Role::TEACHER, Role::ADMINISTRATOR]))) {
			$query = "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid_teacher = :uid_teacher";
			$data = [
				"uid_teacher" => $this->reservation->user->uid
			];
		}

		if (!empty(array_intersect($roleUser, [Role::STUDENT]))) {
			$query = "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid_student = :uid_student";
			$data = [
				"uid_student" => $this->reservation->user->uid
			];
		}

		return ApplicationData::request(
			query: $query,
			data: $data,
			returnType: PDO::FETCH_ASSOC
		);
	}

	/**
	 * Get start date
	 *
	 * @param string $disponibilityUid
	 *
	 * @return string
	 */
	public static function getStartDate(string $disponibilityUid) : string {
		return ApplicationData::request(
			query: "SELECT date_start FROM " . Database::DISPONIBILITIES . " WHERE uid = :uid",
			data: [
				"uid" => $disponibilityUid
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get timestamp of reservation with limit
	 *
	 * @param int $limit
	 *
	 * @return array
	 */
	public function getAllDates(int $limit = 3) : array {
		$dates = [];
		foreach ($this->getReservations() as $reservation) {
			$date = ApplicationData::request(
				query: "SELECT date_start FROM " . Database::DISPONIBILITIES . " WHERE uid = :uid LIMIT :limit",
				data: [
					"uid" => $reservation["uid_disponibilities"],
					"limit" => $limit
				],
				returnType: PDO::FETCH_COLUMN,
				singleValue: true
			);

			array_push(
				$dates, [
					"date" => $date,
					"uid" => $reservation["uid"]
				]
			);
		}

		return $dates;
	}
}
