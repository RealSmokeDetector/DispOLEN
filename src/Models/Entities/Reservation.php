<?php

namespace App\Models\Entities;

class Reservation {
	private ?string $teacherUid;
	private ?string $studentUid;
	private ?string $disponibilitiesUid;
	private ?int $typeId;
	private ?int $reasonId;
	private ?int $stateId;
	private ?string $comment;
	private User $user;

	public function __construct(string $teacherUid = null, string $studentUid = null, string $disponibilitiesUid = null, int $typeId = 1, int $reasonId = 1, int $stateId = 1, string $comment = null, User $user = null) {
		$this->teacherUid = $teacherUid;
		$this->studentUid = $studentUid;
		$this->disponibilitiesUid = $disponibilitiesUid;
		$this->typeId = $typeId;
		$this->reasonId = $reasonId;
		$this->stateId = $stateId;
		$this->comment = $comment;
		$this->user = $user;
	}

	public function __set($name, $value) : void {
		$this->$name = $value;
	}

	public function __get($var) : mixed {
		return $this->$var;
	}
}
