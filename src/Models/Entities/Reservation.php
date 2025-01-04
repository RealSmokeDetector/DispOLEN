<?php

namespace App\Models\Entities;

class Reservation {
	private ?string $uid_teacher;
	private ?string $uid_student;
	private ?string $uid_disponibilities;
	private ?int $id_type;
	private ?int $id_reason;
	private ?int $id_state;
	private ?string $comment;

	public function __construct(string $uid_teacher, string $uid_student, string $uid_disponibilities, int $id_type, int $id_reason, int $id_state, string $comment) {
		$this->uid_teacher = $uid_teacher;
		$this->uid_student = $uid_student;
		$this->uid_disponibilities = $uid_disponibilities;
		$this->id_type = $id_type;
		$this->id_reason = $id_reason;
		$this->id_state = $id_state;
		$this->comment = $comment;
	}

	public function __set($name, $value): void {
		$this->$name = $value;
	}

	public function __get($var): mixed {
		return $this->$var;
	}
}
