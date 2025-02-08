<?php

namespace App\Models\Repositories;

use App\Configs\Database;
use App\Models\Entities\Disponibility;
use App\Utils\ApplicationData;
use App\Utils\System;
use PDO;

class DisponibilityRepository {
	private $disponibility;

	/**
	 * Reservation construct
	 *
	 * @param Disponibility $disponibility
	 */
	public function __construct(Disponibility $disponibility) {
		$this->disponibility = $disponibility;
	}

	/**
	 * Add disponiblity
	 *
	 * @return void
	 */
	public function create() : void {
		ApplicationData::request(
			query: "INSERT INTO " . Database::DISPONIBILITIES . " (uid, uid_user, date_start, date_end) VALUES (:uid, :uid_user, to_timestamp(:startDate), to_timestamp(:endDate))",
			data: [
				"uid" => System::uidGen(size: 16, table: Database::DISPONIBILITIES),
				"uid_user" => $this->disponibility->user->uid,
				"startDate" => $this->disponibility->startDate,
				"endDate" => $this->disponibility->endDate
			]
		);
	}

	/**
	 * Get teacher disponibilities by date
	 *
	 * @param DateRepository $date
	 *
	 * @return array
	 */
	public function getDisponibilities(DateRepository $date) : array {
		$userRepo = new UserRepository(user: $this->disponibility->user);

		return ApplicationData::request(
			query: "SELECT * FROM " . Database::DISPONIBILITIES . " WHERE uid_user = :uid_user AND date_start >= :startDate AND date_start < :endDate",
			data: [
				"uid_user" => $userRepo->getTutor(),
				"startDate" => $date->getDate() . " 08:00:00",
				"endDate" => $date->getDate() . " 19:00:00"
			],
			returnType: PDO::FETCH_ASSOC
		);
	}
}
