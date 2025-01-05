<?php

namespace App\Models\Repositories;

use App\Configs\Database;
use App\Configs\Role;
use App\Models\Entities\Reservation;
use App\Utils\ApplicationData;
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
		ApplicationData::request(
			query: "INSERT INTO " . Database::RESERVATIONS . "(uid_teacher, uid_student, uid_disponibilities, id_type, id_reason, id_state, comment) VALUES (:uid_teacher, :uid_student, :uid_disponibilities, :id_type, :id_reason, :id_state, :comment)",
			data: [
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
	 * @return array
	 */
	public function getInformation() : array {
		$reservationData = ApplicationData::request(
			query: "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid_teacher = :uid_teacher AND uid_student = :uid_student AND uid_disponibilities = :uid_disponibilities",
			data: [
				"uid_teacher" => $this->reservation->teacherUid,
				"uid_student" => $this->reservation->studentUid,
				"uid_disponibilities" => $this->reservation->disponibilitiesUid
			],
			returnType: PDO::FETCH_ASSOC,
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
}
