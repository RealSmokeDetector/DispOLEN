<?php

namespace App\Models\Entities;

class Reservation {
	private string $teacherUid;
	private string $studentUid;
	private string $disponibilitiesUid;
	private ?int $typeId;
	private ?int $reasonId;
	private ?int $stateId;
	private ?string $comment;

	public function __construct(string $teacherUid, string $studentUid, string $disponibilitiesUid, int $typeId = null, int $reasonId = null, int $stateId = null, string $comment = null) {
		$this->teacherUid = $teacherUid;
		$this->studentUid = $studentUid;
		$this->disponibilitiesUid = $disponibilitiesUid;
		$this->typeId = $typeId;
		$this->reasonId = $reasonId;
		$this->stateId = $stateId;
		$this->comment = $comment;
	}

	public function __set($name, $value) : void {
		$this->$name = $value;
	}

	public function __get($var) : mixed {
		return $this->$var;
	}
}
