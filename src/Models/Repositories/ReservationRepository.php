<?php

namespace App\Models\Repositories;

use App\Configs\Database;
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
	public function create(): void {
		ApplicationData::request(
			query: "INSERT INTO " . Database::RESERVATIONS . "(uid_teacher, uid_student, uid_disponibilities) VALUES (:uid_teacher, :uid_student, :uid_disponibilities)",
			data: [
				"uid_teacher" => $this->reservation->uid_teacher,
				"uid_student" => $this->reservation->uid_student,
				"uid_disponibilities" => $this->reservation->uid_disponibilities
			]
		);
	}

	/**
	 * Get information
	 *
	 * @return array
	 */
	public function getInformation(): array {
		$reservationData = ApplicationData::request(
			query: "SELECT * FROM " . Database::RESERVATIONS .  " WHERE uid_teacher = :uid_teacher AND uid_student = :uid_student AND uid_disponibilities = :uid_disponibilities",
			data: [
				"uid_teacher" => $this->reservation->uid_teacher,
				"uid_student" => $this->reservation->uid_student,
				"uid_disponibilities" => $this->reservation->uid_disponibilities
			],
			returnType : PDO::FETCH_ASSOC,
		);

		return $reservationData;
	}
}
