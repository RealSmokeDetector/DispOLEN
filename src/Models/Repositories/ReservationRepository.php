<?php

namespace App\Models\Repositories;

use App\Configs\Database;
use App\Configs\Role;
use App\Models\Entities\Reservation;
use App\Utils\ApplicationData;
use App\Utils\Roles;
use App\Utils\System;
use App\Utils\Date;
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
			query: "INSERT INTO " . Database::RESERVATIONS . "(uid, uid_teacher, uid_student, uid_disponibilities, id_type, id_reason, id_state, date_start, date_end, comment) VALUES (:uid, :uid_teacher, :uid_student, :uid_disponibilities, :id_type, :id_reason, :id_state, :date_start, :date_end, :comment)",
			data: [
				"uid" => $this->reservation->uid,
				"uid_teacher" => $this->reservation->teacherUid,
				"uid_student" => $this->reservation->studentUid,
				"uid_disponibilities" => $this->reservation->disponibilitiesUid,
				"id_type" => $this->reservation->typeId,
				"id_reason" => $this->reservation->reasonId,
				"id_state" => $this->reservation->stateId,
				"date_start" => $this->reservation->date_start,
				"date_end" => $this->reservation->date_end,
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
			query: "UPDATE " . Database::RESERVATIONS . " SET id_type = :id_type, id_reason = :id_reason, id_state = :id_state, date_start = :date_start, date_end = :date_end, comment = :comment WHERE uid = :uid",
			data: [
				"uid" => $this->reservation->uid,
				"id_type" => $this->reservation->typeId,
				"id_reason" => $this->reservation->reasonId,
				"id_state" => $this->reservation->stateId,
				"date_start"=>$this->reservation->date_start,
				"date_end"=>$this->reservation->date_end,
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

		if (Roles::check(userRoles: $roleUser, allowRoles: [Role::TEACHER, Role::ADMINISTRATOR])) {
			$query = "SELECT * FROM " . Database::RESERVATIONS . " WHERE uid_teacher = :uid_teacher LIMIT :limit";
			$data = [
				"uid_teacher" => $this->reservation->user->uid,
				"limit" => $limit
			];
		}

		if (Roles::check(userRoles: $roleUser, allowRoles: [Role::STUDENT])) {
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
	 * @param Date $date
	 *
	 * @return array
	 */
	public function getDisponibilities(Date $date) : array {
		$userRepo = new UserRepository(user: $this->reservation->user);

		return ApplicationData::request(
			query: "SELECT * FROM " . Database::DISPONIBILITIES . " WHERE uid_user = :uid_user AND date_start >= :start_date AND date_start < :end_date",
			data: [
				"uid_user" => $userRepo->getTutor(),
				"start_date" => $date->getDate() . " 08:00:00",
				"end_date" => $date->getDate() . " 19:00:00"
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
	public static function createAvailabilityForToday(string $teacherUid) : bool {
		$today = new Date();
		$interval = $today->GetIntervaleDay(hourStart: 8, hourEnd: 19);

		return ApplicationData::request(
			query: "INSERT INTO " . Database::DISPONIBILITIES . " (uid, date_start, date_end, uid_user) VALUES (:uid, :date_start, :date_end, :uid_user)",
			data: [
				"uid" => System::uidGen(size: 16, table: Database::DISPONIBILITIES),
				"date_start" => $interval["dateStart"],
				"date_end" => $interval["dateEnd"],
				"uid_user" => $teacherUid
			],
		);
	}

	/**
	 * Create and call function in object Date to
	 * formate universal date YYYY-MM-DD HH:mm:ss.000
	 *
	 * @param string $date
	 *
	 * @return bool
	 */
	public function reservationByDate(Date $dateStart = new Date()) : array {
		$dates = [];
		$interval = $dateStart->GetIntervaleDay();
		foreach ($this->getReservations() as $reservation) {
			$date = ApplicationData::request(
				query: "SELECT date_start, date_end FROM " . Database::DISPONIBILITIES . " WHERE date_start >= :dateStartInterval AND date_start <= :dateEndInterval AND uid = :uid",
				data: [
					"dateStartInterval" => $interval["dateStart"],
					"dateEndInterval" => $interval["dateEnd"],
					"uid" => $reservation["uid"]
				],
				returnType: PDO::FETCH_ASSOC,
				singleValue: true
			);
			if ($date) {
				array_push($dates, $date);
			}
		}
		return $dates;
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
	 * Add disponiblity
	 *
	 * @return void
	 */
	public function addDisponibility() : void {
		ApplicationData::request(
			query: "INSERT INTO " . Database::DISPONIBILITIES . " (uid, uid_user, date_start, date_end) VALUES (:uid, :uid_user, to_timestamp(:date_start), to_timestamp(:date_end))",
			data: [
				"uid" => System::uidGen(size: 16, table: Database::DISPONIBILITIES),
				"uid_user" => $this->reservation->user->uid,
				"date_start" => $this->reservation->date_start,
				"date_end" => $this->reservation->date_end
			]
		);
	}

	/**
	 * Check if reserved
	 *
	 * @param array $reservations
	 * @param int $hour
	 *
	 * @return bool
	 */
	public static function isReserved(array $reservations, int $hour) : bool {
		foreach ($reservations as $reservation) {
			$startHour = (int)date(format: "H", timestamp: strtotime(datetime: $reservation["date_start"]));
			$endHour = (int)date(format: "H", timestamp: strtotime(datetime: $reservation["date_end"]));

			if ($hour >= $startHour && $hour < $endHour) {
				return true;
			}
		}

		return false;
	}
}
