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
	public function getReservations(int $limit = null) : array {
		$roleUser = UserRepository::getRoles(uid: $this->reservation->user->uid);

		if (!empty(array_intersect($roleUser, [Role::TEACHER, Role::ADMINISTRATOR]))) {
			$query = "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid_teacher = :uid_teacher LIMIT :limit";
			$data = [
				"uid_teacher" => $this->reservation->user->uid,
				"limit" => $limit
			];
		}

		if (!empty(array_intersect($roleUser, [Role::STUDENT]))) {
			$query = "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid_student = :uid_student LIMIT :limit";
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
	 * Get end date
	 *
	 * @param string $disponibilityUid
	 *
	 * @return string
	 */
	public static function getEndDate(string $disponibilityUid) : string {
		return ApplicationData::request(
			query: "SELECT date_end FROM " . Database::DISPONIBILITIES . " WHERE uid = :uid",
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
	public function getAllDates(int $limit = null) : array {
		$dates = [];
		foreach ($this->getReservations(limit: $limit) as $index=>$reservation) {
			$date = ApplicationData::request(
				query: "SELECT date_start FROM " . Database::DISPONIBILITIES . " WHERE uid = :uid",
				data: [
					"uid" => $reservation["uid_disponibilities"]
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

	/**
	 * Get teacher disponibilities by date
	 *
	 * @param string $date
	 *
	 * @return array
	 */
	public static function getTeacherDisponibilitiesByDate(string $date): array {
	return ApplicationData::request(
		query: "SELECT * FROM " . Database::DISPONIBILITIES . " WHERE date_start::date = :date",
		data: [
			"date" => $date
		],
		returnType: PDO::FETCH_ASSOC
	);
	}

	/**
	 * Create availability for today
	 *
	 * @param string $teacherUid
	 *
	 * @return bool
	 */
	public static function createAvailabilityForToday(string $teacherUid): bool {
		$today = (new DateTime())->format('Y-m-d');

		return ApplicationData::request(
			query: "INSERT INTO " . Database::DISPONIBILITIES . " (uid, date_start, date_end, uid_user) VALUES (:uid, :date_start, :date_end, :uid_user)",
			data: [
				"uid" => uniqid(),
				"date_start" => $today . ' 08:00:00',
				"date_end" => $today . ' 17:00:00',
				"uid_user" => $teacherUid
			],
			returnType: PDO::FETCH_NONE
		);
	}

	}
