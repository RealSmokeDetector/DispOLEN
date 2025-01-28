<?php

namespace App\Models\Repositories;

use App\Models\Entities\Disponibility;

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
}
