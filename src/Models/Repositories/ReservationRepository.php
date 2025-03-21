<?php

namespace App\Models\Repositories;

use App\Configs\Database;
use App\Configs\Role;
use App\Models\Entities\Mail;
use App\Models\Entities\Reservation;
use App\Utils\ApplicationData;
use App\Utils\Lang;
use App\Utils\Roles;
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
			query: "INSERT INTO " . Database::RESERVATIONS . "(uid, uid_teacher, uid_student, uid_disponibilities, id_type, id_reason, id_state, date_start, date_end, comment) VALUES (:uid, :uid_teacher, :uid_student, :uid_disponibilities, :id_type, :id_reason, :id_state, :startDate, :endDate, :comment)",
			data: [
				"uid" => $this->reservation->uid,
				"uid_teacher" => $this->reservation->teacherUid,
				"uid_student" => $this->reservation->studentUid,
				"uid_disponibilities" => $this->reservation->disponibilitiesUid,
				"id_type" => $this->reservation->typeId,
				"id_reason" => $this->reservation->reasonId,
				"id_state" => $this->reservation->stateId,
				"startDate" => $this->reservation->startDate,
				"endDate" => $this->reservation->endDate,
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
			query: "UPDATE " . Database::RESERVATIONS . " SET id_type = :id_type, id_reason = :id_reason, id_state = :id_state, date_start = :startDate, date_end = :endDate, comment = :comment WHERE uid = :uid",
			data: [
				"uid" => $this->reservation->uid,
				"id_type" => $this->reservation->typeId,
				"id_reason" => $this->reservation->reasonId,
				"id_state" => $this->reservation->stateId,
				"startDate" => $this->reservation->startDate,
				"endDate" => $this->reservation->endDate,
				"comment" => $this->reservation->comment
			]
		);

		$reservationInfo = $this->getInformation(uid: $this->reservation->uid);

		$studentInfo = UserRepository::getInformations(uid: $reservationInfo["uid_student"]);
		$teacherInfo = UserRepository::getInformations(uid: $reservationInfo["uid_teacher"]);

		$email = new MailRepository(mail: new Mail(receiver: $studentInfo["email"], body: Lang::translate(key: "EMAIL_UPDATE_RESERVATION_BODY"), object: Lang::translate(key: "EMAIL_UPDATE_RESERVATION_OBJECT")));
		$email->send();

		$email = new MailRepository(mail: new Mail(receiver: $teacherInfo["email"], body: Lang::translate(key: "EMAIL_UPDATE_RESERVATION_BODY"), object: Lang::translate(key: "EMAIL_UPDATE_RESERVATION_OBJECT")));
		$email->send();
	}

	/**
	 * Get informations
	 *
	 * @return null | array
	 */
	public static function getInformation(string $uid) : null | array {
		return ApplicationData::request(
			query: "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid = :uid",
			data: [
				"uid" => $uid,
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);
	}

	/**
	 * Get user's reservations
	 *
	 * @return array
	 */
	public function getReservations(int $limit = null) : array {
		$userRoles = UserRepository::getRoles(uid: $this->reservation->user->uid);

		if (Roles::check(userRoles: $userRoles, allowRoles: [Role::TEACHER, Role::ADMINISTRATOR])) {
			$query = "SELECT uid FROM " . Database::RESERVATIONS . " WHERE uid_teacher = :uid_teacher LIMIT :limit";
			$data = [
				"uid_teacher" => $this->reservation->user->uid,
				"limit" => $limit
			];
		}

		if (Roles::check(userRoles: $userRoles, allowRoles: [Role::STUDENT])) {
			$query = "SELECT uid FROM " . Database::RESERVATIONS . " WHERE uid_student = :uid_student LIMIT :limit";
			$data = [
				"uid_student" => $this->reservation->user->uid,
				"limit" => $limit
			];
		}

		return ApplicationData::request(
			query: $query,
			data: $data,
			returnType: PDO::FETCH_COLUMN
		);
	}

	/**
	 * Set state
	 *
	 * @param int $state
	 *
	 * @return void
	 */
	public function setState(int $state) : void {
		ApplicationData::request(
			query: "UPDATE " . Database::RESERVATIONS . " SET id_state = :id_state WHERE uid = :uid",
			data: [
				"id_state" => $state,
				"uid" => $this->reservation->uid
			]
		);
	}

	/**
	 * Get day's reservations by date
	 *
	 * @param DateRepository $dateRepo
	 *
	 * @return array | null
	 */
	public function reservationByDate(DateRepository $dateRepo) : array | null {
		$interval = $dateRepo->GetIntervalDay();

		return ApplicationData::request(
			query: "SELECT date_start, date_end FROM " . Database::RESERVATIONS . " WHERE date_start >= :startDate AND date_start <= :endDate",
			data: [
				"startDate" => $interval["startDate"],
				"endDate" => $interval["endDate"],
			],
			returnType: PDO::FETCH_ASSOC
		);
	}
}
