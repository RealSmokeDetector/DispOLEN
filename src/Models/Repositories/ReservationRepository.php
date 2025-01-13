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

		if (!empty(array_intersect($roleUser, [Role::TEACHER]))) {
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
	public function getTimeOnReservationWithLimit(int $limit = 3) : array {
		$roleUser = UserRepository::getRoles(uid: $this->reservation->user->uid);
		$query = "SELECT d.date_start FROM " . Database::RESERVATIONS . " r join " . Database::DISPONIBILITIES . " d on r.uid_disponibilities = d.uid LIMIT :limit";
		$data = [
			"limit" => $limit
		];

		if (!empty(array_intersect($roleUser, [Role::TEACHER]))) {
			$query = "SELECT d.date_start FROM " . Database::RESERVATIONS . " r join " . Database::DISPONIBILITIES . " d on r.uid_disponibilities = d.uid WHERE uid_teacher = :uid_teacher and d.date_end > current_timestamp LIMIT :limit";
			$data = [
				"uid_teacher" => $this->reservation->user->uid,
				"limit" => $limit
			];
		}

		if (!empty(array_intersect($roleUser, [Role::STUDENT]))) {
			$query = "SELECT d.date_start FROM " . Database::RESERVATIONS . " r join " . Database::DISPONIBILITIES . " d on r.uid_disponibilities = d.uid WHERE uid_student = :uid_student and d.date_end > current_timestamp LIMIT :limit";
			$data = [
				"uid_student" => $this->reservation->user->uid,
				"limit" => $limit
			];
		}

		return ApplicationData::request(
			query: $query,
			data: $data,
			returnType: PDO::FETCH_ASSOC
		);
	}
}
